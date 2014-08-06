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

class tubepress_embedplus_ioc_compiler_EmbedPlusPass implements tubepress_platform_api_ioc_CompilerPassInterface
{

    /**
     * @param tubepress_platform_api_ioc_ContainerBuilderInterface $containerBuilder The primary service container builder.
     *
     * @api
     * @since 4.0.0
     */
    public function process(tubepress_platform_api_ioc_ContainerBuilderInterface $containerBuilder)
    {
        if ($containerBuilder->hasDefinition('Twig_Loader_Filesystem')) {

            $twigFsLoader = $containerBuilder->getDefinition('Twig_Loader_Filesystem');

            $twigFsLoader->addMethodCall('addPath', array(TUBEPRESS_ROOT . '/src/add-ons/embedplus/templates'));
        }

        if ($containerBuilder->hasDefinition('tubepress_youtube2_impl_listeners_embedded_EmbeddedListener')) {

            $ytListener = $containerBuilder->getDefinition('tubepress_youtube2_impl_listeners_embedded_EmbeddedListener');

            $ytListener->addTag(tubepress_lib_api_ioc_ServiceTags::EVENT_LISTENER, array(
                'event'    => tubepress_app_api_event_Events::TEMPLATE_PRE_RENDER . '.single/embedded/embedplus',
                'method'   => 'onEmbeddedTemplatePreRender',
                'priority' => 10500,
            ));
        }
    }
}