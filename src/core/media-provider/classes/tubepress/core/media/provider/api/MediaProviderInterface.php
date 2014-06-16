<?php
/**
 * Copyright 2006 - 2014 TubePress LLC (http://tubepress.com)
 *
 * This file is part of TubePress (http://tubepress.com)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * Video provider interface.
 *
 * @api
 * @since 4.0.0
 */
interface tubepress_core_media_provider_api_MediaProviderInterface
{
    /**
     * @ignore
     */
    const _ = 'tubepress_core_media_provider_api_MediaProviderInterface';

    /**
     * Ask this media provider if it recognizes the given item ID.
     *
     * @param string $mediaId The globally unique media item identifier.
     *
     * @return boolean True if this provider recognizes the given item ID, false otherwise.
     *
     * @api
     * @since 4.0.0
     */
    function recognizesItemId($mediaId);

    /**
     * Fetch a media page.
     *
     * @param int $currentPage The requested page number of the gallery.
     *
     * @return tubepress_core_media_provider_api_Page The media gallery page for this page. May be empty, never null.
     *
     * @throws tubepress_core_media_provider_api_exception_ProviderException
     *
     * @api
     * @since 4.0.0
     */
    function fetchPage($currentPage);

    /**
     * Fetch a single media item.
     *
     * @param string $itemId The item ID to fetch.
     *
     * @return tubepress_core_media_item_api_MediaItem The media item, or null if unable to retrive.
     *
     * @throws tubepress_core_media_provider_api_exception_ProviderException
     *
     * @api
     * @since 4.0.0
     */
    function fetchSingle($itemId);

    /**
     * @return array An array of the valid option values for the "mode" option.
     *
     * @api
     * @since 4.0.0
     */
    function getGallerySourceNames();

    /**
     * @return string The name of this media provider. Never empty or null. All lowercase alphanumerics and dashes.
     *
     * @api
     * @since 4.0.0
     */
    function getName();

    /**
     * @return string The human-readable name of this media provider.
     *
     * @api
     * @since 4.0.0
     */
    function getDisplayName();

    /**
     * @return array An associative array where the keys are this providers meta
     *               option names and the values are the corresponding media item
     *               attribute names.
     *
     * @api
     * @since 4.0.0
     */
    function getMapOfMetaOptionNamesToAttributeDisplayNames();

    /**
     * @return string The name of the "mode" value that this provider uses for searching.
     *
     * @api
     * @since 4.0.0
     */
    function getSearchModeName();

    /**
     * @return string The option name where TubePress should put the users search results.
     *
     * @api
     * @since 4.0.0
     */
    function getSearchQueryOptionName();

    /**
     * @return array
     *
     * @api
     * @since 4.0.0
     */
    function getMapOfFeedSortNamesToUntranslatedLabels();

    /**
     * @return array
     *
     * @api
     * @since 4.0.0
     */
    function getMapOfPerPageSortNamesToUntranslatedLabels();

    /**
     * @param tubepress_core_media_item_api_MediaItem $first
     * @param tubepress_core_media_item_api_MediaItem $second
     * @param string                                $perPageSort
     *
     * @return int
     */
    function compareForPerPageSort(tubepress_core_media_item_api_MediaItem $first,
                                   tubepress_core_media_item_api_MediaItem $second,
                                   $perPageSort);
}