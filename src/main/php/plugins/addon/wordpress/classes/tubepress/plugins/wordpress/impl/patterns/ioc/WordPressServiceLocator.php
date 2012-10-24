<?php
/**
 * Copyright 2006 - 2012 Eric D. Hough (http://ehough.com)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * A service locator for WordPress services.
 */
class tubepress_plugins_wordpress_impl_patterns_ioc_WordPressServiceLocator
{
    /**
     * @var mixed This is a special member that is a reference to the core IOC service.
     *            It lets us perform lazy lookups for core services.
     */
    private static $_coreIocContainer;


    /**
     * @var tubepress_plugins_wordpress_spi_ContentFilter
     */
    private static $_contentFilter;

    /**
     * @var tubepress_plugins_wordpress_spi_FrontEndCssAndJsInjector
     */
    private static $_frontEndCssAndJsInjector;

    /**
     * @var tubepress_plugins_wordpress_spi_WidgetHandler
     */
    private static $_widgetHandler;

    /**
     * @var tubepress_plugins_wordpress_spi_WordPressFunctionWrapper
     */
    private static $_wordPressFunctionWrapper;

    /**
     * @var tubepress_plugins_wordpress_spi_WpAdminHandler
     */
    private static $_wpAdminHandler;

    /**
     * @return tubepress_plugins_wordpress_spi_ContentFilter The content filter.
     */
    public static function getContentFilter()
    {
        return self::_lazyGet('_contentFilter', tubepress_plugins_wordpress_spi_WordPressServiceIds::CONTENT_FILTER);
    }

    /**
     * @return tubepress_plugins_wordpress_spi_FrontEndCssAndJsInjector The HTML injector.
     */
    public static function getFrontEndCssAndJsInjector()
    {
        return self::_lazyGet('_frontEndCssAndJsInjector', tubepress_plugins_wordpress_spi_WordPressServiceIds::CSS_AND_JS_INJECTOR);
    }

    /**
     * @return tubepress_plugins_wordpress_spi_WidgetHandler Widget handler.
     */
    public static function getWidgetHandler()
    {
        return self::_lazyGet('_widgetHandler', tubepress_plugins_wordpress_spi_WordPressServiceIds::WIDGET_HANDLER);
    }

    /**
     * @return tubepress_plugins_wordpress_spi_WordPressFunctionWrapper The WP function wrapper.
     */
    public static function getWordPressFunctionWrapper()
    {
        return self::_lazyGet('_wordPressFunctionWrapper', tubepress_plugins_wordpress_spi_WordPressServiceIds::WP_FUNCTION_WRAPPER);
    }

    /**
     * @return tubepress_plugins_wordpress_spi_WpAdminHandler The WP Admin handler.
     */
    public static function getWpAdminHandler()
    {
        return self::_lazyGet('_wpAdminHandler', tubepress_plugins_wordpress_spi_WordPressServiceIds::WP_ADMIN_HANDLER);
    }

    /**
     * @param tubepress_plugins_wordpress_spi_ContentFilter $contentFilter The content filter.
     */
    public static function setContentFilter(tubepress_plugins_wordpress_spi_ContentFilter $contentFilter)
    {
        self::$_contentFilter = $contentFilter;
    }

    /**
     * @param tubepress_plugins_wordpress_spi_FrontEndCssAndJsInjector $injector The injector.
     */
    public static function setFrontEndCssAndJsInjector(tubepress_plugins_wordpress_spi_FrontEndCssAndJsInjector $injector)
    {
        self::$_frontEndCssAndJsInjector = $injector;
    }

    /**
     * @param tubepress_plugins_wordpress_spi_WidgetHandler $widgetHandler The widget handler.
     */
    public static function setWidgetHandler(tubepress_plugins_wordpress_spi_WidgetHandler $widgetHandler)
    {
        self::$_widgetHandler = $widgetHandler;
    }

    /**
     * @param tubepress_plugins_wordpress_spi_WordPressFunctionWrapper $wordPressFunctionWrapper The WP function wrapper.
     */
    public static function setWordPressFunctionWrapper(tubepress_plugins_wordpress_spi_WordPressFunctionWrapper $wordPressFunctionWrapper)
    {
        self::$_wordPressFunctionWrapper = $wordPressFunctionWrapper;
    }

    /**
     * @param tubepress_plugins_wordpress_spi_WpAdminHandler $wpAdminHandler The WP Admin handler.
     */
    public static function setWpAdminHandler(tubepress_plugins_wordpress_spi_WpAdminHandler $wpAdminHandler)
    {
        self::$_wpAdminHandler = $wpAdminHandler;
    }

    /**
     * @param ehough_iconic_api_IContainer $container The core IOC container.
     */
    public static function setCoreIocContainer(ehough_iconic_api_IContainer $container)
    {
        self::$_coreIocContainer = $container;
    }

    private static function _lazyGet($propertyName, $iocServiceKey)
    {
        if (! isset(self::${$propertyName}) && isset(self::$_coreIocContainer)) {

            self::${$propertyName} = self::$_coreIocContainer->get($iocServiceKey);
        }

        return self::${$propertyName};
    }
}
