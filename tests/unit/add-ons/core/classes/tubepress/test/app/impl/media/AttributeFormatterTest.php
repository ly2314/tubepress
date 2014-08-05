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
 * @covers tubepress_app_impl_media_AttributeFormatter
 */
class tubepress_test_app_api_media_AttributeFormatterTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var tubepress_app_impl_media_AttributeFormatter
     */
    private $_sut;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockContext;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockTimeUtils;

    public function onSetup()
    {
        $this->_mockContext   = $this->mock(tubepress_app_api_options_ContextInterface::_);
        $this->_mockTimeUtils = $this->mock(tubepress_lib_api_util_TimeUtilsInterface::_);
        
        $this->_sut = new tubepress_app_impl_media_AttributeFormatter(

            $this->_mockContext,
            $this->_mockTimeUtils
        );
    }

    public function testImplodeArray()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn(array('one', 'two', 'three'));
        $mockMediaItem->shouldReceive('setAttribute')->once()->with('dest', 'onextwoxthree');

        $this->_sut->implodeArrayAttribute($mockMediaItem, 'source', 'dest', 'x');
        $this->assertTrue(true);
    }

    public function testFormatDuration()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn(123456);
        $mockMediaItem->shouldReceive('setAttribute')->once()->with('dest', 'hi');

        $this->_mockTimeUtils->shouldReceive('secondsToHumanTime')->once()->with(
            123456
        )->andReturn('hi');

        $this->_sut->formatDurationAttribute($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);
    }

    public function testFormatDate()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn(1406217118);
        $mockMediaItem->shouldReceive('setAttribute')->once()->with('dest', 'hi');

        $this->_mockContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::META_DATEFORMAT)->andReturn('abc');
        $this->_mockContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::META_RELATIVE_DATES)->andReturn(true);
        $this->_mockTimeUtils->shouldReceive('unixTimeToHumanReadable')->once()->with(
            1406217118, 'abc', true
        )->andReturn('hi');

        $this->_sut->formatDateAttribute($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);

    }

    public function testFormatNumber()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn('123.123456');
        $mockMediaItem->shouldReceive('setAttribute')->once()->with('dest', '123.123');

        $this->_sut->formatNumberAttribute($mockMediaItem, 'source', 'dest', 3);
        $this->assertTrue(true);

    }

    public function testTruncate()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn('abc');
        $mockMediaItem->shouldReceive('setAttribute')->once()->with('dest', 'ab...');
        $this->_mockContext->shouldReceive('get')->once()->with('option')->andReturn('2');

        $this->_sut->truncateStringAttribute($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);

    }

    public function testTruncateShorty()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $mockMediaItem->shouldReceive('getAttribute')->once()->with('source')->andReturn('abc');
        $this->_mockContext->shouldReceive('get')->once()->with('option')->andReturn('300');

        $this->_sut->truncateStringAttribute($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);

    }

    public function testTruncateNoLimit()
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(true);
        $this->_mockContext->shouldReceive('get')->once()->with('option')->andReturn('0');

        $this->_sut->truncateStringAttribute($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);

    }

    /**
     * @dataProvider getAttributeMethods
     */
    public function testTruncateNoSuchAttribute($method)
    {
        $mockMediaItem = $this->mock('tubepress_app_api_media_MediaItem');
        $mockMediaItem->shouldReceive('hasAttribute')->once()->with('source')->andReturn(false);

        $this->_sut->$method($mockMediaItem, 'source', 'dest', 'option');
        $this->assertTrue(true);
    }

    public function getAttributeMethods()
    {
        return array(

            array('truncateStringAttribute'),
            array('formatNumberAttribute'),
            array('formatDateAttribute'),
            array('formatDurationAttribute'),
            array('implodeArrayAttribute'),
        );
    }
}