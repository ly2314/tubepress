<?php
/**
 * Copyright 2006 - 2015 TubePress LLC (http://tubepress.com)
 *
 * This file is part of TubePress (http://tubepress.com)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * Handles the heavy lifting for YouTube.
 */
class tubepress_youtube2_impl_media_FeedHandler implements tubepress_app_api_media_HttpFeedHandlerInterface
{
    private static $_NAMESPACE_OPENSEARCH = 'http://a9.com/-/spec/opensearch/1.1/';
    private static $_NAMESPACE_APP        = 'http://www.w3.org/2007/app';
    private static $_NAMESPACE_ATOM       = 'http://www.w3.org/2005/Atom';
    private static $_NAMESPACE_MEDIA      = 'http://search.yahoo.com/mrss/';
    private static $_NAMESPACE_YT         = 'http://gdata.youtube.com/schemas/2007';
    private static $_NAMESPACE_GD         = 'http://schemas.google.com/g/2005';

    private static $_URL_PARAM_FORMAT      = 'format';
    private static $_URL_PARAM_KEY         = 'key';
    private static $_URL_PARAM_MAX_RESULTS = 'max-results';
    private static $_URL_PARAM_ORDER       = 'orderby';
    private static $_URL_PARAM_SAFESEARCH  = 'safeSearch';
    private static $_URL_PARAM_START_INDEX = 'start-index';
    private static $_URL_PARAM_VERSION     = 'v';

    /**
     * @var DOMDocument DOM Document.
     */
    private $_domDocument;

    /**
     * @var DOMXPath XPath.
     */
    private $_xpath;

    /**
     * @var tubepress_platform_api_log_LoggerInterface
     */
    private $_logger;

    /**
     * @var tubepress_app_api_options_ContextInterface
     */
    private $_context;

    /**
     * @var tubepress_platform_api_url_UrlFactoryInterface
     */
    private $_urlFactory;

    /**
     * @var bool
     */
    private $_videoNotFound = false;

    private $_invokedAtLeastOnce;

    public function __construct(tubepress_platform_api_log_LoggerInterface     $logger,
                                tubepress_app_api_options_ContextInterface     $context,
                                tubepress_platform_api_url_UrlFactoryInterface $urlFactory)
    {
        $this->_logger     = $logger;
        $this->_context    = $context;
        $this->_urlFactory = $urlFactory;
    }

    /**
     * @return string The name of this feed handler. Never empty or null. All lowercase alphanumerics and dashes.
     *
     * @api
     * @since 4.0.0
     */
    public function getName()
    {
        return 'youtube_v2';
    }

    /**
     * Apply any data that might be needed from the feed to build attributes for this media item.
     *
     * @param tubepress_app_api_media_MediaItem $mediaItemId The media item.
     * @param int                               $index       The zero-based index.
     *
     * @return array
     *
     * @api
     * @since 4.0.0
     */
    public function getNewItemEventArguments(tubepress_app_api_media_MediaItem $mediaItemId, $index)
    {
        return array(
            'domDocument'    => $this->_domDocument,
            'xpath'          => $this->_xpath,
            'zeroBasedIndex' => $index
        );
    }

    /**
     * Builds a URL for a list of videos
     *
     * @param int $currentPage The current page number of the gallery.
     *
     * @return tubepress_platform_api_url_UrlInterface The request URL for this gallery.
     *
     * @api
     * @since 4.0.0
     */
    public function buildUrlForPage($currentPage)
    {
        switch ($this->_context->get(tubepress_app_api_options_Names::GALLERY_SOURCE)) {

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_USER:

                $url = 'users/' . $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_USER_VALUE) . '/uploads';

                break;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_MOST_POPULAR:

                $url = 'standardfeeds/most_popular?time=' . $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_MOST_POPULAR_VALUE);

                break;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_PLAYLIST:

                $url = 'playlists/' . $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_PLAYLIST_VALUE);

                break;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_RELATED:

                $url = 'videos/' . $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_RELATED_VALUE) . '/related';

                break;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_FAVORITES:

                $url = 'users/' . $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_FAVORITES_VALUE) . '/favorites';

                break;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_SEARCH:

                $tags = $this->_context->get(tubepress_youtube2_api_Constants::OPTION_YOUTUBE_TAG_VALUE);
                $tags = self::_replaceQuotes($tags);
                $tags = urlencode($tags);
                $url  = "videos?q=$tags";

                $filter = $this->_context->get(tubepress_app_api_options_Names::SEARCH_ONLY_USER);

                if ($filter != '') {

                    $url .= "&author=$filter";
                }

                break;

            default:

                throw new LogicException('Invalid source supplied to YouTube');
        }

        $requestUrl = $this->_urlFactory->fromString("http://gdata.youtube.com/feeds/api/$url");

        $this->_urlPostProcessingCommon($requestUrl);

        $this->_urlPostProcessingGallery($requestUrl, $currentPage);

        return $requestUrl;
    }

    /**
     * Builds a request url for a single video
     *
     * @param string $id The video ID to search for
     *
     * @throws InvalidArgumentException If unable to build a URL for the given video.
     *
     * @return tubepress_platform_api_url_UrlInterface The URL for the single video given.
     *
     * @api
     * @since 4.0.0
     */
    public function buildUrlForItem($id)
    {
        $requestURL = $this->_urlFactory->fromString("http://gdata.youtube.com/feeds/api/videos/$id");

        $this->_urlPostProcessingCommon($requestURL);

        return $requestURL;
    }

    /**
     * Count the total videos in this feed result.
     *
     * @return int The total result count of this query.
     *
     * @api
     * @since 4.0.0
     */
    public function getTotalResultCount()
    {
        $total        = $this->_domDocument->getElementsByTagNameNS(self::$_NAMESPACE_OPENSEARCH, '*');
        $node         = $total->item(0);
        $totalResults = $node->nodeValue;

        self::_makeSureNumeric($totalResults);

        return $totalResults;
    }

    /**
     * Determine why the given item cannot be used.
     *
     * @param integer $index The index into the feed.
     *
     * @return string The reason why we can't work with this video, or null if we can.
     *
     * @api
     * @since 4.0.0
     */
    public function getReasonUnableToUseItemAtIndex($index)
    {
        $states = $this->_relativeQuery($index, 'app:control/yt:state');

        /* no state applied? we're good to go */
        if ($states->length == 0) {

            return null;
        }

        /**
         * @var $stateNodeList DOMNodeList
         */
        $stateNodeList = $this->_relativeQuery($index, "app:control/yt:state[@reasonCode='limitedSyndication']");

        /**
         * @var $stateNode DOMNode
         */
        foreach ($stateNodeList as $stateNode) {

            foreach ($stateNode->attributes as $name => $value) {

                if ($name === 'reasonCode' && $value->nodeValue !== 'limitedSyndication') {

                    return 'embedding restricted';
                }
            }
        }

        return null;
    }

    /**
     * Count the number of videos that we think are in this feed.
     *
     * @return integer A count of videos in this feed.
     *
     * @api
     * @since 4.0.0
     */
    public function getCurrentResultCount()
    {
        if ($this->_videoNotFound) {

            return 0;
        }

        return $this->_xpath->query('//atom:entry')->length;
    }

    /**
     * Perform pre-construction activites for the feed.
     *
     * @param mixed $feed The feed to construct.
     *
     * @return void
     *
     * @api
     * @since 4.0.0
     */
    public function onAnalysisStart($feed)
    {
        $this->_createDomDocument($feed);
        $this->_xpath = $this->_createXPath($this->_domDocument);

        $this->_checkForError();
    }

    /**
     * Perform post-construction activites for the feed.
     *
     * @return void
     *
     * @api
     * @since 4.0.0
     */
    public function onAnalysisComplete()
    {
        unset($this->_domDocument);
        unset($this->_xpath);
    }

    /**
     * Get the item ID of an element of the feed.
     *
     * @param integer $index The index into the feed.
     *
     * @return string The globally unique item ID.
     *
     * @api
     * @since 4.0.0
     */
    public function getIdForItemAtIndex($index)
    {
        $fromGallery = $this->_relativeQuery($index, 'media:group/yt:videoid');

        if ($fromGallery->length > 0) {

            return $fromGallery->item(0)->nodeValue;
        }

        $url = $this->_relativeQuery($index, 'atom:id')->item(0)->nodeValue;
        $id  = substr($url, strrpos($url, '/') + 1);

        return $id;
    }

    private static function _replaceQuotes($text)
    {
        return str_replace(array('&#8216', '&#8217', '&#8242;', '&#34', '&#8220;', '&#8221;', '&#8243;'), '"', $text);
    }

    private function _urlPostProcessingCommon(tubepress_platform_api_url_UrlInterface $url)
    {
        $query = $url->getQuery();
        $query->set(self::$_URL_PARAM_VERSION, 2);
        $query->set(self::$_URL_PARAM_KEY, $this->_context->get(tubepress_youtube2_api_Constants::OPTION_DEV_KEY));
    }

    private function _urlPostProcessingGallery(tubepress_platform_api_url_UrlInterface $url, $currentPage)
    {
        if (isset($this->_invokedAtLeastOnce)) {
            $perPage = $this->_context->get(tubepress_app_api_options_Names::FEED_RESULTS_PER_PAGE);
        } else {
            $perPage = min($this->_context->get(tubepress_app_api_options_Names::FEED_RESULTS_PER_PAGE), ceil(2.07));
        }

        /* start index of the videos */
        $start = ($currentPage * $perPage) - $perPage + 1;

        $query                              = $url->getQuery();
        $query->set(self::$_URL_PARAM_START_INDEX, $start);
        $query->set(self::$_URL_PARAM_MAX_RESULTS, $perPage);

        $this->_urlProcessingOrderBy($url);

        $query->set(self::$_URL_PARAM_SAFESEARCH, $this->_context->get(tubepress_youtube2_api_Constants::OPTION_FILTER));

        if ($this->_context->get(tubepress_youtube2_api_Constants::OPTION_EMBEDDABLE_ONLY)) {

            $query->set(self::$_URL_PARAM_FORMAT, '5');
        }
    }

    private function _urlProcessingOrderBy(tubepress_platform_api_url_UrlInterface $url)
    {
        /*
         * In a request for a video feed, the following values are valid for this parameter:
         *
         * relevance – Entries are ordered by their relevance to a search query. This is the default setting for video search results feeds.
         * published – Entries are returned in reverse chronological order. This is the default value for video feeds other than search results feeds.
         * viewCount – Entries are ordered from most views to least views.
         * rating – Entries are ordered from highest rating to lowest rating.
         *
         * In a request for a playlist feed, the following values are valid for this parameter:
         *
         * position – Entries are ordered by their position in the playlist. This is the default setting.
         * commentCount – Entries are ordered by number of comments from most comments to least comments.
         * duration – Entries are ordered by length of each playlist video from longest video to shortest video.
         * published – Entries are returned in reverse chronological order.
         * reversedPosition – Entries are ordered in reverse of their position in the playlist.
         * title – Entries are ordered alphabetically by title.
         * viewCount – Entries are ordered from most views to least views.
         */

        $requestedSortOrder   = $this->_context->get(tubepress_app_api_options_Names::FEED_ORDER_BY);
        $currentGallerySource = $this->_context->get(tubepress_app_api_options_Names::GALLERY_SOURCE);
        $query                = $url->getQuery();

        if ($requestedSortOrder === tubepress_app_api_options_AcceptableValues::ORDER_BY_DEFAULT) {

            $query->set(self::$_URL_PARAM_ORDER, $this->_calculateDefaultSearchOrder($currentGallerySource));
            return;
        }

        if ($requestedSortOrder === tubepress_youtube2_api_Constants::ORDER_BY_NEWEST) {

            $query->set(self::$_URL_PARAM_ORDER, 'published');
            return;
        }

        if ($requestedSortOrder == tubepress_youtube2_api_Constants::ORDER_BY_VIEW_COUNT) {

            $query->set(self::$_URL_PARAM_ORDER, $requestedSortOrder);

            return;
        }

        if ($currentGallerySource == tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_PLAYLIST) {

            if (in_array($requestedSortOrder, array(

                tubepress_youtube2_api_Constants::ORDER_BY_POSITION,
                tubepress_youtube2_api_Constants::ORDER_BY_COMMENT_COUNT,
                tubepress_youtube2_api_Constants::ORDER_BY_DURATION,
                tubepress_youtube2_api_Constants::ORDER_BY_REV_POSITION,
                tubepress_youtube2_api_Constants::ORDER_BY_TITLE,

            ))) {

                $query->set(self::$_URL_PARAM_ORDER, $requestedSortOrder);
                return;
            }

        } else {

            if (in_array($requestedSortOrder, array(tubepress_youtube2_api_Constants::ORDER_BY_RELEVANCE, tubepress_youtube2_api_Constants::ORDER_BY_RATING))) {

                $query->set(self::$_URL_PARAM_ORDER, $requestedSortOrder);
            }
        }
    }

    private function _calculateDefaultSearchOrder($currentGallerySource)
    {
        switch ($currentGallerySource) {

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_MOST_POPULAR:

                return tubepress_youtube2_api_Constants::ORDER_BY_VIEW_COUNT;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_PLAYLIST:

                return tubepress_youtube2_api_Constants::ORDER_BY_POSITION;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_SEARCH:
            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_RELATED:

                return tubepress_youtube2_api_Constants::ORDER_BY_RELEVANCE;

            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_USER:
            case tubepress_youtube2_api_Constants::GALLERYSOURCE_YOUTUBE_FAVORITES:

                return 'published';
        }
    }

    private static function _makeSureNumeric($result)
    {
        if (is_numeric($result) === false) {

            throw new RuntimeException("YouTube returned a non-numeric result count: $result");
        }
    }

    private function _createXPath(DOMDocument $doc)
    {
        if ($this->_logger->isEnabled()) {

            $this->_logger->debug('Building xpath to parse XML');
        }

        if (! class_exists('DOMXPath')) {

            throw new RuntimeException('Class DOMXPath not found');
        }

        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('atom', self::$_NAMESPACE_ATOM);
        $xpath->registerNamespace('yt', self::$_NAMESPACE_YT);
        $xpath->registerNamespace('gd', self::$_NAMESPACE_GD);
        $xpath->registerNamespace('media', self::$_NAMESPACE_MEDIA);
        $xpath->registerNamespace('app', self::$_NAMESPACE_APP);

        return $xpath;
    }

    private function _createDomDocument($feed)
    {
        if ($this->_logger->isEnabled()) {

            $this->_logger->debug('Attempting to load XML from YouTube');
        }

        if (! class_exists('DOMDocument')) {

            throw new RuntimeException('DOMDocument class not found');
        }

        $doc = new DOMDocument();

        if ($doc->loadXML($feed) === false) {

            throw new RuntimeException('Could not parse XML from YouTube');
        }

        if ($this->_logger->isEnabled()) {

            $this->_logger->debug('Successfully loaded XML from YouTube');
        }

        $this->_domDocument = $doc;
    }

    /**
     * @param $index
     * @param $query
     *
     * @return DOMNodeList
     */
    private function _relativeQuery($index, $query)
    {
        return $this->_xpath->query('//atom:entry[' . ($index + 1) . "]/$query");
    }

    private function _checkForError()
    {
        $errors = $this->_xpath->query('//gd:errors');

        if ($errors->length === 0) {

            return;
        }

        $reason = $this->_xpath->query('//gd:errors/gd:error/gd:internalReason');
        $reason = $reason->item(0)->nodeValue;

        if ($reason === 'Video not found') {

            $this->_videoFound = true;

        } else {

            throw new RuntimeException($reason);
        }
    }

    public function __invoke()
    {
        $this->_invokedAtLeastOnce = true;
    }
}