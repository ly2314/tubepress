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
 * @covers tubepress_wordpress_impl_Callback
 */
class tubepress_test_wordpress_impl_CallbackTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEventDispatcher;

    /**
     * @var tubepress_wordpress_impl_Callback
     */
    private $_sut;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockActivationHook;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockHtmlGenerator;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockOptionsReference;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockContext;

    public function onSetup()
    {
        $mockEnvironmentDetector     = $this->mock(tubepress_app_api_environment_EnvironmentInterface::_);
        $mockWpFunctions             = $this->mock(tubepress_wordpress_impl_wp_WpFunctions::_);
        $this->_mockEventDispatcher  = $this->mock('tubepress_lib_api_event_EventDispatcherInterface');
        $this->_mockActivationHook   = $this->mock('tubepress_wordpress_impl_wp_ActivationHook');
        $this->_mockHtmlGenerator    = $this->mock(tubepress_app_api_html_HtmlGeneratorInterface::_);
        $this->_mockContext          = $this->mock(tubepress_app_api_options_ContextInterface::_);
        $this->_mockOptionsReference = $this->mock(tubepress_app_api_options_ReferenceInterface::_);

        $mockWpFunctions->shouldReceive('content_url')->once()->andReturn('booya');
        $mockEnvironmentDetector->shouldReceive('setBaseUrl')->once()->with('booya/plugins/core');

        $this->_sut = new tubepress_wordpress_impl_Callback(

            $mockEnvironmentDetector,
            $this->_mockEventDispatcher,
            $this->_mockContext,
            $this->_mockHtmlGenerator,
            $this->_mockOptionsReference,
            $mockWpFunctions,
            $this->_mockActivationHook
        );
    }

    public function testNonArrayIncoming()
    {
        $this->_mockOptionsReference->shouldReceive('getAllOptionNames')->once()->andReturn(array('foO'));

        $this->_mockHtmlGenerator->shouldReceive('getHtml')->once()->andReturn('html for shortcode');

        $this->_mockContext->shouldReceive('setEphemeralOptions')->twice()->with(array());

        $result = $this->_sut->onShortcode('');

        $this->assertEquals('html for shortcode', $result);
    }

    public function testShortcode()
    {
        $this->_mockOptionsReference->shouldReceive('getAllOptionNames')->once()->andReturn(array('foO'));

        $this->_mockHtmlGenerator->shouldReceive('getHtml')->once()->andReturn('html for shortcode');

        $this->_mockContext->shouldReceive('setEphemeralOptions')->once()->with(array('foO' => 'bar'));
        $this->_mockContext->shouldReceive('setEphemeralOptions')->once()->with(array());

        $options = array('foo' => 'bar');

        $result = $this->_sut->onShortcode($options);

        $this->assertEquals('html for shortcode', $result);
    }

    public function testFilter()
    {
        $args = array(1, 'two', array('three'));

        $mockFilterEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockFilterEvent->shouldReceive('getSubject')->once()->andReturn('abc');

        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with(1, array('args' => array('two', array('three'))))->andReturn($mockFilterEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with('tubepress.wordpress.filter.someFilter', $mockFilterEvent);

        $result = $this->_sut->onFilter('someFilter', $args);

        $this->assertEquals('abc', $result);
    }

    public function testAction()
    {
        $mockActionEvent = $this->mock('tubepress_lib_api_event_EventInterface');

        $args = array(1, 'two', array('three'));

        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with($args)->andReturn($mockActionEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with('tubepress.wordpress.action.someAction', $mockActionEvent);

        $this->_sut->onAction('someAction', $args);

        $this->assertTrue(true);
    }

    public function testPluginActivation()
    {
        $this->_mockActivationHook->shouldReceive('execute')->once();

        $this->_sut->onPluginActivation();

        $this->assertTrue(true);
    }

    public function __callback($event)
    {
        return $event instanceof tubepress_lib_api_event_EventInterface
        && $event->getSubject() === array(1, 'two', array('three'));
    }
}