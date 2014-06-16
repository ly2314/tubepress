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
 * Generates the HTML for an embeddable Flash/HTML5 media player
 *
 * @api
 * @since 4.0.0
 */
interface tubepress_core_embedded_api_EmbeddedHtmlInterface
{
    /**
     * @ignore
     */
    const _ = 'tubepress_core_embedded_api_EmbeddedHtmlInterface';

    /**
     * Return the HTML for this embedded player
     *
     * @param string $mediaId The media ID to display
     *
     * @return string The text for this embedded player, or null if there was a problem.
     *
     * @api
     * @since 4.0.0
     */
    function getHtml($mediaId);
}
