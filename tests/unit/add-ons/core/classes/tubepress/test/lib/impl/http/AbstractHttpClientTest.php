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
 * @covers tubepress_lib_impl_http_AbstractHttpClient<extended>
 */
class tubepress_test_lib_http_impl_AbstractHttpClientTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEventDispatcher;

    public function onSetup()
    {
        $this->_mockEventDispatcher = $this->mock(tubepress_lib_api_event_EventDispatcherInterface::_);
    }

    public function testSlowSend()
    {
        $client = new tubepress_test_lib_http_impl_AbstractHttpClientTest__noErrorClient($this->_mockEventDispatcher);
        $mockRequest = $this->mock('tubepress_lib_api_http_message_RequestInterface');

        $mockBeforeEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockBeforeEvent->shouldReceive('hasArgument')->once()->with('response')->andReturn(true);
        $mockBeforeEvent->shouldReceive('getArgument')->once()->with('response')->andReturn(null);

        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with($mockRequest, array('response' => null))->andReturn($mockBeforeEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_lib_api_http_Events::EVENT_HTTP_REQUEST, $mockBeforeEvent);

        $mockResponse = $this->mock('tubepress_lib_api_http_message_ResponseInterface');

        $mockAfterEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockAfterEvent->shouldReceive('getSubject')->once()->andReturn($mockResponse);
        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with(ehough_mockery_Mockery::type('tubepress_lib_api_http_message_ResponseInterface'), array('request' => $mockRequest))->andReturn($mockAfterEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_lib_api_http_Events::EVENT_HTTP_RESPONSE, $mockAfterEvent);

        $result = $client->send($mockRequest);

        $this->assertInstanceOf('tubepress_lib_api_http_message_ResponseInterface', $result);
    }

    public function testQuickSend()
    {
        $client = new tubepress_test_lib_http_impl_AbstractHttpClientTest__noErrorClient($this->_mockEventDispatcher);
        $mockRequest = $this->mock('tubepress_lib_api_http_message_RequestInterface');

        $mockResponse = $this->mock('tubepress_lib_api_http_message_ResponseInterface');

        $mockBeforeEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockBeforeEvent->shouldReceive('hasArgument')->once()->with('response')->andReturn(true);
        $mockBeforeEvent->shouldReceive('getArgument')->twice()->with('response')->andReturn($mockResponse);

        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with($mockRequest, array('response' => null))->andReturn($mockBeforeEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_lib_api_http_Events::EVENT_HTTP_REQUEST, $mockBeforeEvent);

        $mockAfterEvent = $this->mock('tubepress_lib_api_event_EventInterface');
        $mockAfterEvent->shouldReceive('getSubject')->once()->andReturn($mockResponse);
        $this->_mockEventDispatcher->shouldReceive('newEventInstance')->once()->with($mockResponse, array('request' => $mockRequest))->andReturn($mockAfterEvent);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_lib_api_http_Events::EVENT_HTTP_RESPONSE, $mockAfterEvent);

        $result = $client->send($mockRequest);

        $this->assertSame($mockResponse, $result);
    }
}

if (!class_exists('tubepress_test_lib_impl_http_AbstractHttpClientTest__client')) {

    class tubepress_test_lib_http_impl_AbstractHttpClientTest__noErrorClient extends tubepress_lib_impl_http_AbstractHttpClient
    {
        /**
         * Sends a single request
         *
         * @param tubepress_lib_api_http_message_RequestInterface $request Request to send
         *
         * @return tubepress_lib_api_http_message_ResponseInterface
         * @throws LogicException When the underlying implementation does not populate a response
         * @throws tubepress_lib_api_http_exception_RequestException When an error is encountered
         */
        protected function doSend(tubepress_lib_api_http_message_RequestInterface $request)
        {
            return ehough_mockery_Mockery::mock('tubepress_lib_api_http_message_ResponseInterface');
        }

        public function createRequest($method, $url = null, array $options = array())
        {
            return ehough_mockery_Mockery::mock('tubepress_lib_api_http_message_RequestInterface');
        }

        public function getDefaultOption($keyOrPath = null) {}
        public function setDefaultOption($keyOrPath, $value) {}
    }
}