<?php
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
class tubepress_addons_vimeo_impl_BootstrapTest extends TubePressUnitTest
{
    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEventDispatcher;


    public function onSetup()
    {
        $this->_mockEventDispatcher = $this->createMockSingletonService('ehough_tickertape_EventDispatcherInterface');
    }

    public function testInit()
    {
        $this->_testEventHandler();

        require TUBEPRESS_ROOT . '/src/main/php/addons/vimeo/scripts/bootstrap.php';

        $this->assertTrue(true);
    }

    private function _testEventHandler()
    {
        $this->_mockEventDispatcher->shouldReceive('addListenerService')->once()->with(

            tubepress_api_const_event_EventNames::BOOT_COMPLETE,
            array('tubepress_addons_vimeo_impl_listeners_boot_VimeoOptionsRegistrar', 'onBoot')
        );

        $this->_mockEventDispatcher->shouldReceive('addListenerService')->once()->with(

            tubepress_api_const_event_EventNames::VIDEO_CONSTRUCTION,
            array('tubepress_addons_vimeo_impl_listeners_video_VimeoVideoConstructionListener',
            'onVideoConstruction')
        );

        $this->_mockEventDispatcher->shouldReceive('addListenerService')->once()->with(

            ehough_shortstop_api_Events::RESPONSE,
            array('tubepress_addons_vimeo_impl_listeners_http_VimeoHttpErrorResponseListener',
            'onResponse')
        );
    }
}