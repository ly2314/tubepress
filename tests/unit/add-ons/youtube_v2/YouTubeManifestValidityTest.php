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

class tubepress_test_app_YouTubeManifestValidityTest extends tubepress_test_platform_impl_boot_helper_uncached_contrib_AbstractManifestTest
{
    public function testManifest()
    {
        /**
         * @var $addon tubepress_platform_api_addon_AddonInterface
         */
        $addon = $this->getAddonFromManifest($this->getPathToManifest());

        $this->assertEquals('tubepress/youtube', $addon->getName());
        $this->assertEquals('99.99.99', $addon->getVersion());
        $this->assertEquals('YouTube', $addon->getTitle());
        $this->assertAuthors($addon, array(array('name' => 'TubePress LLC', 'url' => 'http://tubepress.com')));
        $this->assertLicense($addon, array('type' => 'MPL-2.0', 'urls' => array('http://www.mozilla.org/MPL/2.0/')));
        $this->assertEquals('Allows TubePress work with YouTube', $addon->getDescription());
    }

    protected function getPathToManifest()
    {
        return TUBEPRESS_ROOT . '/src/add-ons/youtube_v2/manifest.json';
    }
}