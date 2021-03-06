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
 * @covers tubepress_wordpress_impl_wp_Widget
 */
class tubepress_test_wordpress_impl_WidgetTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var tubepress_wordpress_impl_wp_Widget
     */
    private $_sut;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockTranslator;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockContext;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEnvironment;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockTemplating;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockRequestParams;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockShortcodeParser;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockHtmlGenerator;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockPersistence;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockStringUtils;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockWpFunctions;

    /**
     * @var ehough_mockery_mockery_MockInterface
     */
    private $_mockEvent;

    public function onSetup()
    {
        $this->_mockEvent           = $this->mock('tubepress_lib_api_event_EventInterface');
        $this->_mockTranslator      = $this->mock(tubepress_lib_api_translation_TranslatorInterface::_);
        $this->_mockContext         = $this->mock(tubepress_app_api_options_ContextInterface::_);
        $this->_mockEnvironment     = $this->mock(tubepress_app_api_environment_EnvironmentInterface::_);
        $this->_mockTemplating      = $this->mock(tubepress_lib_api_template_TemplatingInterface::_);
        $this->_mockShortcodeParser = $this->mock(tubepress_app_api_shortcode_ParserInterface::_);
        $this->_mockRequestParams   = $this->mock(tubepress_lib_api_http_RequestParametersInterface::_);
        $this->_mockHtmlGenerator   = $this->mock(tubepress_app_api_html_HtmlGeneratorInterface::_);
        $this->_mockPersistence     = $this->mock(tubepress_app_api_options_PersistenceInterface::_);
        $this->_mockWpFunctions     = $this->mock(tubepress_wordpress_impl_wp_WpFunctions::_);
        $this->_mockStringUtils     = $this->mock(tubepress_platform_api_util_StringUtilsInterface::_);

        $this->_mockTranslator->shouldReceive('trans')->atLeast(1)->andReturnUsing( function ($key) {
            return "<<$key>>";
        });

        $this->_sut = new tubepress_wordpress_impl_wp_Widget(
            $this->_mockContext,
            $this->_mockPersistence,
            $this->_mockTranslator,
            $this->_mockHtmlGenerator,
            $this->_mockShortcodeParser,
            $this->_mockWpFunctions,
            $this->_mockStringUtils,
            $this->_mockRequestParams,
            $this->_mockTemplating
        );
    }

    public function testPrintWidgetControl()
    {
        $this->_mockPersistence->shouldReceive('fetch')->once()->with(tubepress_wordpress_api_Constants::OPTION_WIDGET_TITLE)->andReturn('value of widget title');
        $this->_mockPersistence->shouldReceive('fetch')->once()->with(tubepress_wordpress_api_Constants::OPTION_WIDGET_SHORTCODE)->andReturn('value of widget shortcode');
        $this->_mockRequestParams->shouldReceive('hasParam')->once()->with('tubepress-widget-submit')->andReturn(false);
        $this->_mockWpFunctions->shouldReceive('wp_nonce_field')->once()->with('tubepress-widget-nonce-save', 'tubepress-widget-nonce', true, false)->andReturn('nonce-field');
        $this->_mockTemplating->shouldReceive('renderTemplate')->once()->with('wordpress/single-widget-controls', array(
            tubepress_wordpress_impl_wp_Widget::WIDGET_CONTROL_TITLE     => '<<Title>>',
            tubepress_wordpress_impl_wp_Widget::WIDGET_TITLE             => 'value of widget title',
            tubepress_wordpress_impl_wp_Widget::WIDGET_CONTROL_SHORTCODE => '<<TubePress shortcode for the widget. See the <a href="http://docs.tubepress.com/" target="_blank">documentation</a>.>>',
            tubepress_wordpress_impl_wp_Widget::WIDGET_SHORTCODE         => 'value of widget shortcode',
            tubepress_wordpress_impl_wp_Widget::WIDGET_SUBMIT_TAG        => tubepress_wordpress_impl_wp_Widget::WIDGET_SUBMIT_TAG,
            tubepress_wordpress_impl_wp_Widget::WIDGET_NONCE_FIELD       => 'nonce-field',
        ))->andReturn('final result');

        ob_start();

        $this->_sut->printControlHtml();

        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('final result', $contents);
    }

    public function testPrintWidget()
    {
        $this->_mockContext->shouldReceive('get')->once()->with(tubepress_wordpress_api_Constants::OPTION_WIDGET_SHORTCODE)->andReturn('shortcode string');
        $this->_mockContext->shouldReceive('get')->once()->with(tubepress_app_api_options_Names::THEME)->andReturn('theme');
        $this->_mockContext->shouldReceive('get')->once()->with(tubepress_wordpress_api_Constants::OPTION_WIDGET_TITLE)->andReturn('widget title');
        $this->_mockContext->shouldReceive('getEphemeralOptions')->once()->andReturn(array(tubepress_app_api_options_Names::GALLERY_THUMB_WIDTH => 22135));
        $this->_mockContext->shouldReceive('setEphemeralOptions')->once()->with(array(
            tubepress_app_api_options_Names::FEED_RESULTS_PER_PAGE    => 3,
            tubepress_app_api_options_Names::META_DISPLAY_VIEWS                  => false,
            tubepress_app_api_options_Names::META_DISPLAY_DESCRIPTION            => true,
            tubepress_app_api_options_Names::META_DESC_LIMIT          => 50,
            tubepress_app_api_options_Names::PLAYER_LOCATION => 'shadowbox',
            tubepress_app_api_options_Names::GALLERY_THUMB_HEIGHT        => 105,
            tubepress_app_api_options_Names::GALLERY_THUMB_WIDTH         => 22135,
            tubepress_app_api_options_Names::GALLERY_PAGINATE_ABOVE      => false,
            tubepress_app_api_options_Names::GALLERY_PAGINATE_BELOW      => false,
            tubepress_app_api_options_Names::THEME               => 'tubepress/default',
            tubepress_app_api_options_Names::GALLERY_FLUID_THUMBS        => false
        ));
        $this->_mockContext->shouldReceive('setEphemeralOptions')->once()->with(array());

        $this->_mockHtmlGenerator->shouldReceive('getHtml')->once()->andReturn('html result');

        $this->_mockShortcodeParser->shouldReceive('parse')->once()->with('syz');

        $this->_mockStringUtils->shouldReceive('removeNewLines')->once()->with('shortcode string')->andReturn('syz');

        $this->_mockEvent->shouldReceive('getSubject')->once()->andReturn(
            array(
                'before_widget' => 'before_widget',
                'before_title'  => 'before_title',
                'after_title'   => 'after_title',
                'after_widget'  => 'after_widget'
            )
        );

        ob_start();
        $this->_sut->printWidgetHtml($this->_mockEvent);
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('before_widgetbefore_titlewidget titleafter_titlehtml resultafter_widget', $contents);
    }
}