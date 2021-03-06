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
 * @covers tubepress_app_impl_listeners_html_generation_SoloPlayerListener
 */
class tubepress_test_app_impl_listeners_html_generation_SoloPlayerListenerTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var tubepress_app_impl_listeners_html_generation_SoloPlayerListener
     */
    private $_sut;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockExecutionContext;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockHttpRequestParameterService;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockLogger;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEvent;

    public function onSetup()
    {

        $this->_mockExecutionContext            = $this->mock(tubepress_app_api_options_ContextInterface::_);
        $this->_mockHttpRequestParameterService = $this->mock(tubepress_lib_api_http_RequestParametersInterface::_);
        $this->_mockLogger                      = $this->mock(tubepress_platform_api_log_LoggerInterface::_);
        $this->_mockEvent                       = $this->mock('tubepress_lib_api_event_EventInterface');

        $this->_mockLogger->shouldReceive('isEnabled')->atLeast(1)->andReturn(true);
        $this->_mockLogger->shouldReceive('debug')->atLeast(1);

        $this->_sut = new tubepress_app_impl_listeners_html_generation_SoloPlayerListener(

            $this->_mockLogger,
            $this->_mockExecutionContext,
            $this->_mockHttpRequestParameterService
        );
    }

    public function testExecuteWrongPlayer()
    {
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::PLAYER_LOCATION)->andReturn('shadowbox');

        $this->_sut->onHtmlGeneration($this->_mockEvent);
        $this->assertTrue(true);
    }

    public function testExecuteNoVideoId()
    {
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::PLAYER_LOCATION)->andReturn('solo');

        $this->_mockHttpRequestParameterService->shouldReceive('getParamValue')->once()->with('tubepress_item')->andReturn('');

        $this->_sut->onHtmlGeneration($this->_mockEvent);
        $this->assertTrue(true);
    }

    public function testExecute()
    {
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::PLAYER_LOCATION)->andReturn('solo');

        $this->_mockExecutionContext->shouldReceive('setEphemeralOption')->once()->with(tubepress_app_api_options_Names::SINGLE_MEDIA_ITEM_ID, 'video-id')->andReturn(true);

        $this->_mockHttpRequestParameterService->shouldReceive('getParamValue')->twice()->with('tubepress_item')->andReturn('video-id');

        $this->_sut->onHtmlGeneration($this->_mockEvent);
        $this->assertTrue(true);
    }
}