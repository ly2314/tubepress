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
 * @covers tubepress_app_impl_listeners_options_set_LoggingListener<extended>
 */
class tubepress_test_app_impl_listeners_options_set_LoggingListenerTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockReference;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockTranslator;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockLogger;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockStringUtils;

    /**
     * @var tubepress_app_impl_listeners_options_set_LoggingListener
     */
    private $_sut;

    public function onSetup()
    {
        $this->_mockLogger = $this->mock(tubepress_platform_api_log_LoggerInterface::_);
        $this->_mockStringUtils  = $this->mock(tubepress_platform_api_util_StringUtilsInterface::_);

        $this->_mockLogger->shouldReceive('isEnabled')->once()->andReturn(true);

        $this->_sut = new tubepress_app_impl_listeners_options_set_LoggingListener(

            $this->_mockLogger,
            $this->_mockStringUtils
        );
    }

    public function testBadValue()
    {
        $event = $this->_getMockEvent('value', array('foo', 'bar'));

        $this->_mockStringUtils->shouldReceive('redactSecrets')->once()->with('value')->andReturn('hi');
        $this->_mockLogger->shouldReceive('error')->once()->with('Rejecting invalid value: \'name\' = \'hi\' (foo)');

        $this->_sut->onOptionSet($event);
        $this->assertTrue(true);
    }

    public function testGoodValue()
    {
        $event = $this->_getMockEvent('value', array());

        $this->_mockStringUtils->shouldReceive('redactSecrets')->once()->with('value')->andReturn('hi');
        $this->_mockLogger->shouldReceive('debug')->once()->with('Accepted valid value: \'name\' = \'hi\'');

        $this->_sut->onOptionSet($event);
        $this->assertTrue(true);
    }

    /**
     * @return ehough_mockery_mockery_MockInterface
     */
    private function _getMockEvent($value, $subject)
    {
        $mockEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockEvent->shouldReceive('getSubject')->once()->andReturn($subject);
        $mockEvent->shouldReceive('getArgument')->once()->with('optionName')->andReturn('name');
        $mockEvent->shouldReceive('getArgument')->once()->with('optionValue')->andReturn($value);

        return $mockEvent;
    }
}