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
 *
 */
class tubepress_core_media_provider_ioc_ProviderExtension implements tubepress_api_ioc_ContainerExtensionInterface
{

    /**
     * Called during construction of the TubePress service container. If an add-on intends to add
     * services to the container, it should do so here. The incoming `tubepress_api_ioc_ContainerBuilderInterface`
     * will be completely empty, and after this method is executed will be merged into the primary service container.
     *
     * @param tubepress_api_ioc_ContainerBuilderInterface $containerBuilder An empty `tubepress_api_ioc_ContainerBuilderInterface` instance.
     *
     * @return void
     *
     * @api
     * @since 4.0.0
     */
    public function load(tubepress_api_ioc_ContainerBuilderInterface $containerBuilder)
    {
        $containerBuilder->register(

            tubepress_core_media_provider_api_CollectorInterface::_,
            'tubepress_core_media_provider_impl_Collector'
        )->addArgument(new tubepress_api_ioc_Reference(tubepress_api_log_LoggerInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_options_api_ContextInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_event_api_EventDispatcherInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_http_api_RequestParametersInterface::_))
         ->addTag(tubepress_core_ioc_api_Constants::TAG_TAGGED_SERVICES_CONSUMER, array(
            'tag'    => tubepress_core_media_provider_api_MediaProviderInterface::_,
            'method' => 'setMediaProviders'
        ));

        $containerBuilder->register(

            tubepress_core_media_provider_api_ItemSorterInterface::_,
            'tubepress_core_media_provider_impl_ItemSorter'
        );

        $containerBuilder->register(
            'tubepress_core_media_provider_impl_listeners_options_AcceptableValues',
            'tubepress_core_media_provider_impl_listeners_options_AcceptableValues'
        )->addTag(tubepress_core_ioc_api_Constants::TAG_TAGGED_SERVICES_CONSUMER, array(
            'tag'    => tubepress_core_media_provider_api_MediaProviderInterface::_,
            'method' => 'setMediaProviders'
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_options_api_Constants::EVENT_OPTION_GET_ACCEPTABLE_VALUES . '.' . tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY,
            'method'   => 'onOrderBy',
            'priority' => 10300
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_options_api_Constants::EVENT_OPTION_GET_ACCEPTABLE_VALUES . '.' . tubepress_core_media_provider_api_Constants::OPTION_GALLERY_SOURCE,
            'method'   => 'onMode',
            'priority' => 10300
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_options_api_Constants::EVENT_OPTION_GET_ACCEPTABLE_VALUES . '.' . tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT,
            'method'   => 'onPerPageSort',
            'priority' => 10300
        ));

        $containerBuilder->register(

            'tubepress_core_media_provider_impl_listeners_page_CorePageListener',
            'tubepress_core_media_provider_impl_listeners_page_CorePageListener'
        )->addArgument(new tubepress_api_ioc_Reference(tubepress_api_log_LoggerInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_options_api_ContextInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_http_api_RequestParametersInterface::_))
         ->addArgument(new tubepress_api_ioc_Reference(tubepress_core_media_provider_api_CollectorInterface::_))
         ->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_media_provider_api_Constants::EVENT_NEW_MEDIA_PAGE,
            'method'   => 'perPageSort',
            'priority' => 10300
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_media_provider_api_Constants::EVENT_NEW_MEDIA_PAGE,
            'method'   => 'capResults',
            'priority' => 10100
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event'    => tubepress_core_media_provider_api_Constants::EVENT_NEW_MEDIA_PAGE,
            'method'   => 'blacklist',
            'priority' => 10200
        ))->addTag(tubepress_core_ioc_api_Constants::TAG_EVENT_LISTENER, array(
            'event' => tubepress_core_media_provider_api_Constants::EVENT_NEW_MEDIA_PAGE,
            'method' => 'prependItems',
            'priority' => 10000
        ));

        $containerBuilder->setParameter(tubepress_core_options_api_Constants::IOC_PARAM_EASY_REFERENCE . '_provider', array(

            'defaultValues' => array(
                tubepress_core_media_provider_api_Constants::OPTION_GALLERY_SOURCE   => tubepress_youtube_api_Constants::GALLERYSOURCE_YOUTUBE_MOST_POPULAR,
                tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY         => 'default',
                tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT    => tubepress_core_media_provider_api_Constants::PER_PAGE_SORT_NONE,
                tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP => 0,
                tubepress_core_media_provider_api_Constants::OPTION_ITEM_ID_BLACKLIST  => null,
                tubepress_core_media_provider_api_Constants::OPTION_RESULTS_PER_PAGE => 20,
            ),

            'labels' => array(
                tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY         => 'Order videos by',                    //>(translatable)<
                tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT    => 'Per-page sort order',                //>(translatable)<
                tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP => 'Maximum total videos to retrieve',   //>(translatable)<
                tubepress_core_media_provider_api_Constants::OPTION_ITEM_ID_BLACKLIST  => 'Video blacklist',                    //>(translatable)<
                tubepress_core_media_provider_api_Constants::OPTION_RESULTS_PER_PAGE => 'Thumbnails per page',                //>(translatable)<
            ),

            'descriptions' => array(
                tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY         =>
                    sprintf('Not all sort orders can be applied to all gallery types. See the <a href="%s" target="_blank">documentation</a> for more info.', "http://docs.tubepress.com/page/reference/options/core.html#orderby"),  //>(translatable)<

                tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT    =>
                    'Additional sort order applied to each individual page of a gallery',                           //>(translatable)<

                tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP =>
                    'This can help to reduce the number of pages in your gallery. Set to "0" to remove any limit.', //>(translatable)<

                tubepress_core_media_provider_api_Constants::OPTION_ITEM_ID_BLACKLIST  =>
                    'A list of video IDs that should never be displayed.',                                          //>(translatable)<

                tubepress_core_media_provider_api_Constants::OPTION_RESULTS_PER_PAGE =>
                    sprintf('Default is %s. Maximum is %s.', 20, 50),                                               //>(translatable)<
            )
        ));

        $containerBuilder->setParameter(tubepress_core_options_api_Constants::IOC_PARAM_EASY_ACCEPTABLE_VALUES .
            '_' . tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT, array(

            'optionName' => tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT,
            'priority'   => 30000,
            'values'     => array(

                tubepress_core_media_provider_api_Constants::PER_PAGE_SORT_NONE   => 'none',                          //>(translatable)<
                tubepress_core_media_provider_api_Constants::PER_PAGE_SORT_RANDOM => 'random',                        //>(translatable)<
            )
        ));

        $containerBuilder->setParameter(tubepress_core_options_api_Constants::IOC_PARAM_EASY_VALIDATION . '_provider', array(

            'priority' => 30000,
            'map'      => array(
                'positiveInteger' => array(
                    tubepress_core_media_provider_api_Constants::OPTION_RESULTS_PER_PAGE,
                ),
                'nonNegativeInteger' => array(
                    tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP,
                )
            )
        ));

        $categoryIndex = 0;
        $categoryIdsToNamesMap = array(
            tubepress_core_media_provider_api_Constants::OPTIONS_UI_CATEGORY_GALLERY_SOURCE => 'Which videos?',
            tubepress_core_media_provider_api_Constants::OPTIONS_UI_CATEGORY_FEED           => 'Feed'
        );
        foreach ($categoryIdsToNamesMap as $id => $name) {
            $containerBuilder->register(
                'media_provider_category_' . $categoryIndex++,
                'tubepress_core_options_ui_api_ElementInterface'
            )->setFactoryService(tubepress_core_options_ui_api_ElementBuilderInterface::_)
                ->setFactoryMethod('newInstance')
                ->addArgument($id)
                ->addArgument($name);
        }
        $categoryReferences = array();
        for ($x = 0; $x < $categoryIndex; $x++) {
            $categoryReferences[] = new tubepress_api_ioc_Reference('media_provider_category_' . $x);
        }

        $fieldIndex = 0;
        $fieldMap = array(
            'text' => array(
                tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP,
                tubepress_core_media_provider_api_Constants::OPTION_ITEM_ID_BLACKLIST,
            ),
            'dropdown' => array(
                tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY,
                tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT
            )

        );
        foreach ($fieldMap as $type => $ids) {
            foreach ($ids as $id) {
                $containerBuilder->register(
                    'media_provider_field_' . $fieldIndex++,
                    'tubepress_core_options_ui_api_FieldInterface'
                )->setFactoryService(tubepress_core_options_ui_api_FieldBuilderInterface::_)
                    ->setFactoryMethod('newInstance')
                    ->addArgument($id)
                    ->addArgument($type);
            }
        }
        $fieldReferences = array();
        for ($x = 0; $x < $fieldIndex; $x++) {
            $fieldReferences[] = new tubepress_api_ioc_Reference('media_provider_field_' . $x);
        }
        $fieldMap = array(
            tubepress_core_media_provider_api_Constants::OPTIONS_UI_CATEGORY_FEED => array(
                tubepress_core_media_provider_api_Constants::OPTION_ORDER_BY,
                tubepress_core_media_provider_api_Constants::OPTION_PER_PAGE_SORT,
                tubepress_core_media_provider_api_Constants::OPTION_RESULT_COUNT_CAP,
                tubepress_core_media_provider_api_Constants::OPTION_ITEM_ID_BLACKLIST,
            )
        );

        $containerBuilder->register(
            'tubepress_core_media_provider_impl_options_ui_FieldProvider',
            'tubepress_core_media_provider_impl_options_ui_FieldProvider'
        )->addArgument($categoryReferences)
         ->addArgument($fieldReferences)
         ->addArgument($fieldMap)
         ->addTag('tubepress_core_options_ui_api_FieldProviderInterface');
    }
}