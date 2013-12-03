<?php
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.com)
 *
 * This file is part of TubePress (http://tubepress.com)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
/**
 * What's this weird file? Well, it's a "cache" of class names to their respective locations
 * within TubePress. This reduces file IO and speeds up class loading significantly.
 */

$chainPrefix       = TUBEPRESS_ROOT . '/vendor/ehough/chaingang/src/main/php/ehough/chaingang';
$contemplatePrefix = TUBEPRESS_ROOT . '/vendor/ehough/contemplate/src/main/php/ehough/contemplate';
$fsPrefix          = TUBEPRESS_ROOT . '/vendor/ehough/filesystem/src/main/php/ehough/filesystem';
$finderPrefix      = TUBEPRESS_ROOT . '/vendor/ehough/finder/src/main/php/ehough/finder';
$iconicPrefix      = TUBEPRESS_ROOT . '/vendor/ehough/iconic/src/main/php/ehough/iconic';
$shortstopPrefix   = TUBEPRESS_ROOT . '/vendor/ehough/shortstop/src/main/php/ehough/shortstop';
$stashPrefix       = TUBEPRESS_ROOT . '/vendor/ehough/stash/src/main/php/ehough/stash';
$tickerTapePrefix  = TUBEPRESS_ROOT . '/vendor/ehough/tickertape/src/main/php/ehough/tickertape';
$oldPrefix1        = TUBEPRESS_ROOT . '/src/main/php/deprecated/classes/org';
$apiPrefix         = TUBEPRESS_ROOT . '/src/main/php/classes/tubepress/api';
$implPrefix        = TUBEPRESS_ROOT . '/src/main/php/classes/tubepress/impl';
$oldPrefix2        = TUBEPRESS_ROOT . '/src/main/php/deprecated/classes/tubepress/plugins';
$spiPrefix         = TUBEPRESS_ROOT . '/src/main/php/classes/tubepress/spi';

return array(

    'ehough_chaingang_api_Chain'                           => $chainPrefix . '/api/Chain.php',
    'ehough_chaingang_api_Command'                         => $chainPrefix . '/api/Command.php',
    'ehough_chaingang_api_Context'                         => $chainPrefix . '/api/Context.php',
    'ehough_chaingang_api_exception_IllegalStateException' => $chainPrefix . '/api/exception/IllegalStateException.php',
    'ehough_chaingang_impl_StandardChain'                  => $chainPrefix . '/impl/StandardChain.php',
    'ehough_chaingang_impl_StandardContext'                => $chainPrefix . '/impl/StandardContext.php',

    'ehough_contemplate_api_exception_IException'               => $contemplatePrefix . '/api/exception/IException.php',
    'ehough_contemplate_api_exception_InvalidArgumentException' => $contemplatePrefix . '/api/exception/InvalidArgumentException.php',
    'ehough_contemplate_api_TemplateBuilder'                    => $contemplatePrefix . '/api/TemplateBuilder.php',
    'ehough_contemplate_api_Template'                           => $contemplatePrefix . '/api/Template.php',
    'ehough_contemplate_impl_SimpleTemplateBuilder'             => $contemplatePrefix . '/impl/SimpleTemplateBuilder.php',
    'ehough_contemplate_impl_SimpleTemplate'                    => $contemplatePrefix . '/impl/SimpleTemplate.php',

    'ehough_curly_Url' => TUBEPRESS_ROOT . '/vendor/ehough/curly/src/main/php/ehough/curly/Url.php',

    'ehough_filesystem_exception_ExceptionInterface'                => $fsPrefix . '/exception/ExceptionInterface.php',
    'ehough_filesystem_exception_IOException'                       => $fsPrefix . '/exception/IOException.php',
    'ehough_filesystem_Filesystem'                                  => $fsPrefix . '/Filesystem.php',
    'ehough_filesystem_FilesystemInterface'                         => $fsPrefix . '/FilesystemInterface.php',
    'ehough_filesystem_iterator_SkipDotsRecursiveDirectoryIterator' => $fsPrefix . '/iterator/SkipDotsRecursiveDirectoryIterator.php',

    'ehough_finder_adapter_AbstractAdapter'                     => $finderPrefix . '/adapter/AbstractAdapter.php',
    'ehough_finder_adapter_AbstractFindAdapter'                 => $finderPrefix . '/adapter/AbstractFindAdapter.php',
    'ehough_finder_adapter_AdapterInterface'                    => $finderPrefix . '/adapter/AdapterInterface.php',
    'ehough_finder_adapter_BsdFindAdapter'                      => $finderPrefix . '/adapter/BsdFindAdapter.php',
    'ehough_finder_adapter_GnuFindAdapter'                      => $finderPrefix . '/adapter/GnuFindAdapter.php',
    'ehough_finder_adapter_PhpAdapter'                          => $finderPrefix . '/adapter/PhpAdapter.php',
    'ehough_finder_comparator_Comparator'                       => $finderPrefix . '/comparator/Comparator.php',
    'ehough_finder_comparator_DateComparator'                   => $finderPrefix . '/comparator/DateComparator.php',
    'ehough_finder_comparator_NumberComparator'                 => $finderPrefix . '/comparator/NumberComparator.php',
    'ehough_finder_exception_AccessDeniedException'             => $finderPrefix . '/exception/AccessDeniedException.php',
    'ehough_finder_exception_AdapterFailureException'           => $finderPrefix . '/exception/AdapterFailureException.php',
    'ehough_finder_exception_ExceptionInterface'                => $finderPrefix . '/exception/ExceptionInterface.php',
    'ehough_finder_exception_OperationNotPermitedException'     => $finderPrefix . '/exception/OperationNotPermitedException.php',
    'ehough_finder_exception_ShellCommandFailureException'      => $finderPrefix . '/exception/ShellCommandFailureException.php',
    'ehough_finder_expression_Expression'                       => $finderPrefix . '/expression/Expression.php',
    'ehough_finder_expression_Glob'                             => $finderPrefix . '/expression/Glob.php',
    'ehough_finder_expression_Regex'                            => $finderPrefix . '/expression/Regex.php',
    'ehough_finder_expression_ValueInterface'                   => $finderPrefix . '/expression/ValueInterface.php',
    'ehough_finder_FinderFactory'                               => $finderPrefix . '/FinderFactory.php',
    'ehough_finder_FinderFactoryInterface'                      => $finderPrefix . '/FinderFactoryInterface.php',
    'ehough_finder_Finder'                                      => $finderPrefix . '/Finder.php',
    'ehough_finder_FinderInterface'                             => $finderPrefix . '/FinderInterface.php',
    'ehough_finder_Glob'                                        => $finderPrefix . '/Glob.php',
    'ehough_finder_iterator_CustomFilterIterator'               => $finderPrefix . '/iterator/CustomFilterIterator.php',
    'ehough_finder_iterator_DateRangeFilterIterator'            => $finderPrefix . '/iterator/DateRangeFilterIterator.php',
    'ehough_finder_iterator_DepthRangeFilterIterator'           => $finderPrefix . '/iterator/DepthRangeFilterIterator.php',
    'ehough_finder_iterator_ExcludeDirectoryFilterIterator'     => $finderPrefix . '/iterator/ExcludeDirectoryFilterIterator.php',
    'ehough_finder_iterator_FilecontentFilterIterator'          => $finderPrefix . '/iterator/FilecontentFilterIterator.php',
    'ehough_finder_iterator_FilenameFilterIterator'             => $finderPrefix . '/iterator/FilenameFilterIterator.php',
    'ehough_finder_iterator_FilePathsIterator'                  => $finderPrefix . '/iterator/FilePathsIterator.php',
    'ehough_finder_iterator_FileTypeFilterIterator'             => $finderPrefix . '/iterator/FileTypeFilterIterator.php',
    'ehough_finder_iterator_FilterIterator'                     => $finderPrefix . '/iterator/FilterIterator.php',
    'ehough_finder_iterator_MultiplePcreFilterIterator'         => $finderPrefix . '/iterator/MultiplePcreFilterIterator.php',
    'ehough_finder_iterator_PathFilterIterator'                 => $finderPrefix . '/iterator/PathFilterIterator.php',
    'ehough_finder_iterator_RecursiveDirectoryIterator'         => $finderPrefix . '/iterator/RecursiveDirectoryIterator.php',
    'ehough_finder_iterator_SizeRangeFilterIterator'            => $finderPrefix . '/iterator/SizeRangeFilterIterator.php',
    'ehough_finder_iterator_SkipDotsRecursiveDirectoryIterator' => $finderPrefix . '/iterator/SkipDotsRecursiveDirectoryIterator.php',
    'ehough_finder_iterator_SortableIterator'                   => $finderPrefix . '/iterator/SortableIterator.php',
    'ehough_finder_shell_Command'                               => $finderPrefix . '/shell/Command.php',
    'ehough_finder_shell_Shell'                                 => $finderPrefix . '/shell/Shell.php',
    'ehough_finder_SplFileInfo'                                 => $finderPrefix . '/SplFileInfo.php',

    'ehough_iconic_Alias'                                                 => $iconicPrefix . '/Alias.php',
    'ehough_iconic_compiler_AnalyzeServiceReferencesPass'                 => $iconicPrefix . '/compiler/AnalyzeServiceReferencesPass.php',
    'ehough_iconic_compiler_CheckCircularReferencesPass'                  => $iconicPrefix . '/compiler/CheckCircularReferencesPass.php',
    'ehough_iconic_compiler_CheckDefinitionValidityPass'                  => $iconicPrefix . '/compiler/CheckDefinitionValidityPass.php',
    'ehough_iconic_compiler_CheckExceptionOnInvalidReferenceBehaviorPass' => $iconicPrefix . '/compiler/CheckExceptionOnInvalidReferenceBehaviorPass.php',
    'ehough_iconic_compiler_CheckReferenceValidityPass'                   => $iconicPrefix . '/compiler/CheckReferenceValidityPass.php',
    'ehough_iconic_compiler_Compiler'                                     => $iconicPrefix . '/compiler/Compiler.php',
    'ehough_iconic_compiler_CompilerPassInterface'                        => $iconicPrefix . '/compiler/CompilerPassInterface.php',
    'ehough_iconic_compiler_InlineServiceDefinitionsPass'                 => $iconicPrefix . '/compiler/InlineServiceDefinitionsPass.php',
    'ehough_iconic_compiler_LoggingFormatter'                             => $iconicPrefix . '/compiler/LoggingFormatter.php',
    'ehough_iconic_compiler_MergeExtensionConfigurationPass'              => $iconicPrefix . '/compiler/MergeExtensionConfigurationPass.php',
    'ehough_iconic_compiler_PassConfig'                                   => $iconicPrefix . '/compiler/PassConfig.php',
    'ehough_iconic_compiler_RemoveAbstractDefinitionsPass'                => $iconicPrefix . '/compiler/RemoveAbstractDefinitionsPass.php',
    'ehough_iconic_compiler_RemovePrivateAliasesPass'                     => $iconicPrefix . '/compiler/RemovePrivateAliasesPass.php',
    'ehough_iconic_compiler_RemoveUnusedDefinitionsPass'                  => $iconicPrefix . '/compiler/RemoveUnusedDefinitionsPass.php',
    'ehough_iconic_compiler_RepeatablePassInterface'                      => $iconicPrefix . '/compiler/RepeatablePassInterface.php',
    'ehough_iconic_compiler_RepeatedPass'                                 => $iconicPrefix . '/compiler/RepeatedPass.php',
    'ehough_iconic_compiler_ReplaceAliasByActualDefinitionPass'           => $iconicPrefix . '/compiler/ReplaceAliasByActualDefinitionPass.php',
    'ehough_iconic_compiler_ResolveDefinitionTemplatesPass'               => $iconicPrefix . '/compiler/ResolveDefinitionTemplatesPass.php',
    'ehough_iconic_compiler_ResolveInvalidReferencesPass'                 => $iconicPrefix . '/compiler/ResolveInvalidReferencesPass.php',
    'ehough_iconic_compiler_ResolveParameterPlaceHoldersPass'             => $iconicPrefix . '/compiler/ResolveParameterPlaceHoldersPass.php',
    'ehough_iconic_compiler_ResolveReferencesToAliasesPass'               => $iconicPrefix . '/compiler/ResolveReferencesToAliasesPass.php',
    'ehough_iconic_compiler_ServiceReferenceGraphEdge'                    => $iconicPrefix . '/compiler/ServiceReferenceGraphEdge.php',
    'ehough_iconic_compiler_ServiceReferenceGraph'                        => $iconicPrefix . '/compiler/ServiceReferenceGraph.php',
    'ehough_iconic_compiler_ServiceReferenceGraphNode'                    => $iconicPrefix . '/compiler/ServiceReferenceGraphNode.php',
    'ehough_iconic_Container'                                             => $iconicPrefix . '/Container.php',
    'ehough_iconic_ContainerAware'                                        => $iconicPrefix . '/ContainerAware.php',
    'ehough_iconic_ContainerAwareInterface'                               => $iconicPrefix . '/ContainerAwareInterface.php',
    'ehough_iconic_ContainerBuilder'                                      => $iconicPrefix . '/ContainerBuilder.php',
    'ehough_iconic_ContainerInterface'                                    => $iconicPrefix . '/ContainerInterface.php',
    'ehough_iconic_DefinitionDecorator'                                   => $iconicPrefix . '/DefinitionDecorator.php',
    'ehough_iconic_Definition'                                            => $iconicPrefix . '/Definition.php',
    'ehough_iconic_exception_BadMethodCallException'                      => $iconicPrefix . '/exception/BadMethodCallException.php',
    'ehough_iconic_exception_ExceptionInterface'                          => $iconicPrefix . '/exception/ExceptionInterface.php',
    'ehough_iconic_exception_InactiveScopeException'                      => $iconicPrefix . '/exception/InactiveScopeException.php',
    'ehough_iconic_exception_InvalidArgumentException'                    => $iconicPrefix . '/exception/InvalidArgumentException.php',
    'ehough_iconic_exception_LogicException'                              => $iconicPrefix . '/exception/LogicException.php',
    'ehough_iconic_exception_OutOfBoundsException'                        => $iconicPrefix . '/exception/OutOfBoundsException.php',
    'ehough_iconic_exception_ParameterCircularReferenceException'         => $iconicPrefix . '/exception/ParameterCircularReferenceException.php',
    'ehough_iconic_exception_ParameterNotFoundException'                  => $iconicPrefix . '/exception/ParameterNotFoundException.php',
    'ehough_iconic_exception_RuntimeException'                            => $iconicPrefix . '/exception/RuntimeException.php',
    'ehough_iconic_exception_ScopeCrossingInjectionException'             => $iconicPrefix . '/exception/ScopeCrossingInjectionException.php',
    'ehough_iconic_exception_ScopeWideningInjectionException'             => $iconicPrefix . '/exception/ScopeWideningInjectionException.php',
    'ehough_iconic_exception_ServiceCircularReferenceException'           => $iconicPrefix . '/exception/ServiceCircularReferenceException.php',
    'ehough_iconic_exception_ServiceNotFoundException'                    => $iconicPrefix . '/exception/ServiceNotFoundException.php',
    'ehough_iconic_extension_ConfigurationExtensionInterface'             => $iconicPrefix . '/extension/ConfigurationExtensionInterface.php',
    'ehough_iconic_extension_Extension'                                   => $iconicPrefix . '/extension/Extension.php',
    'ehough_iconic_extension_ExtensionInterface'                          => $iconicPrefix . '/extension/ExtensionInterface.php',
    'ehough_iconic_extension_PrependExtensionInterface'                   => $iconicPrefix . '/extension/PrependExtensionInterface.php',
    'ehough_iconic_IntrospectableContainerInterface'                      => $iconicPrefix . '/IntrospectableContainerInterface.php',
    'ehough_iconic_parameterbag_FrozenParameterBag'                       => $iconicPrefix . '/parameterbag/FrozenParameterBag.php',
    'ehough_iconic_parameterbag_ParameterBag'                             => $iconicPrefix . '/parameterbag/ParameterBag.php',
    'ehough_iconic_parameterbag_ParameterBagInterface'                    => $iconicPrefix . '/parameterbag/ParameterBagInterface.php',
    'ehough_iconic_Parameter'                                             => $iconicPrefix . '/Parameter.php',
    'ehough_iconic_Reference'                                             => $iconicPrefix . '/Reference.php',
    'ehough_iconic_TaggedContainerInterface'                              => $iconicPrefix . '/TaggedContainerInterface.php',
    'ehough_iconic_Variable'                                              => $iconicPrefix . '/Variable.php',

    'ehough_shortstop_api_Events'                                                             => $shortstopPrefix . '/api/Events.php',
    'ehough_shortstop_api_exception_IException'                                               => $shortstopPrefix . '/api/exception/IException.php',
    'ehough_shortstop_api_exception_InvalidArgumentException'                                 => $shortstopPrefix . '/api/exception/InvalidArgumentException.php',
    'ehough_shortstop_api_exception_LogicException'                                           => $shortstopPrefix . '/api/exception/LogicException.php',
    'ehough_shortstop_api_exception_RuntimeException'                                         => $shortstopPrefix . '/api/exception/RuntimeException.php',
    'ehough_shortstop_api_HttpClientInterface'                                                => $shortstopPrefix . '/api/HttpClientInterface.php',
    'ehough_shortstop_api_HttpEntity'                                                         => $shortstopPrefix . '/api/HttpEntity.php',
    'ehough_shortstop_api_HttpMessage'                                                        => $shortstopPrefix . '/api/HttpMessage.php',
    'ehough_shortstop_api_HttpRequest'                                                        => $shortstopPrefix . '/api/HttpRequest.php',
    'ehough_shortstop_api_HttpResponse'                                                       => $shortstopPrefix . '/api/HttpResponse.php',
    'ehough_shortstop_impl_decoding_AbstractDecodingChain'                                    => $shortstopPrefix . '/impl/decoding/AbstractDecodingChain.php',
    'ehough_shortstop_impl_decoding_content_command_AbstractContentDecompressingCommand'      => $shortstopPrefix . '/impl/decoding/content/command/AbstractContentDecompressingCommand.php',
    'ehough_shortstop_impl_decoding_content_command_NativeDeflateRfc1950DecompressingCommand' => $shortstopPrefix . '/impl/decoding/content/command/NativeDeflateRfc1950DecompressingCommand.php',
    'ehough_shortstop_impl_decoding_content_command_NativeDeflateRfc1951DecompressingCommand' => $shortstopPrefix . '/impl/decoding/content/command/NativeDeflateRfc1951DecompressingCommand.php',
    'ehough_shortstop_impl_decoding_content_command_NativeGzipDecompressingCommand'           => $shortstopPrefix . '/impl/decoding/content/command/NativeGzipDecompressingCommand.php',
    'ehough_shortstop_impl_decoding_content_command_SimulatedGzipDecompressingCommand'        => $shortstopPrefix . '/impl/decoding/content/command/SimulatedGzipDecompressingCommand.php',
    'ehough_shortstop_impl_decoding_content_HttpContentDecodingChain'                         => $shortstopPrefix . '/impl/decoding/content/HttpContentDecodingChain.php',
    'ehough_shortstop_impl_decoding_transfer_command_ChunkedTransferDecodingCommand'          => $shortstopPrefix . '/impl/decoding/transfer/command/ChunkedTransferDecodingCommand.php',
    'ehough_shortstop_impl_decoding_transfer_HttpTransferDecodingChain'                       => $shortstopPrefix . '/impl/decoding/transfer/HttpTransferDecodingChain.php',
    'ehough_shortstop_impl_DefaultHttpClient'                                                 => $shortstopPrefix . '/impl/DefaultHttpClient.php',
    'ehough_shortstop_impl_exec_command_AbstractHttpExecutionCommand'                         => $shortstopPrefix . '/impl/exec/command/AbstractHttpExecutionCommand.php',
    'ehough_shortstop_impl_exec_command_CurlCommand'                                          => $shortstopPrefix . '/impl/exec/command/CurlCommand.php',
    'ehough_shortstop_impl_exec_command_ExtCommand'                                           => $shortstopPrefix . '/impl/exec/command/ExtCommand.php',
    'ehough_shortstop_impl_exec_command_FopenCommand'                                         => $shortstopPrefix . '/impl/exec/command/FopenCommand.php',
    'ehough_shortstop_impl_exec_command_FsockOpenCommand'                                     => $shortstopPrefix . '/impl/exec/command/FsockOpenCommand.php',
    'ehough_shortstop_impl_exec_command_StreamsCommand'                                       => $shortstopPrefix . '/impl/exec/command/StreamsCommand.php',
    'ehough_shortstop_impl_exec_DefaultHttpMessageParser'                                     => $shortstopPrefix . '/impl/exec/DefaultHttpMessageParser.php',
    'ehough_shortstop_impl_listeners_request_RequestDefaultHeadersListener'                   => $shortstopPrefix . '/impl/listeners/request/RequestDefaultHeadersListener.php',
    'ehough_shortstop_impl_listeners_request_RequestLoggingListener'                          => $shortstopPrefix . '/impl/listeners/request/RequestLoggingListener.php',
    'ehough_shortstop_impl_listeners_response_ResponseDecodingListener'                       => $shortstopPrefix . '/impl/listeners/response/ResponseDecodingListener.php',
    'ehough_shortstop_impl_listeners_response_ResponseLoggingListener'                        => $shortstopPrefix . '/impl/listeners/response/ResponseLoggingListener.php',
    'ehough_shortstop_spi_HttpContentDecoder'                                                 => $shortstopPrefix . '/spi/HttpContentDecoder.php',
    'ehough_shortstop_spi_HttpMessageParser'                                                  => $shortstopPrefix . '/spi/HttpMessageParser.php',
    'ehough_shortstop_spi_HttpResponseDecoder'                                                => $shortstopPrefix . '/spi/HttpResponseDecoder.php',
    'ehough_shortstop_spi_HttpTransferDecoder'                                                => $shortstopPrefix . '/spi/HttpTransferDecoder.php',
    'ehough_shortstop_spi_HttpTransport'                                                      => $shortstopPrefix . '/spi/HttpTransport.php',

    'ehough_stash_driver_DriverInterface'             => $stashPrefix . '/driver/DriverInterface.php',
    'ehough_stash_driver_FileSystem'                  => $stashPrefix . '/driver/FileSystem.php',
    'ehough_stash_Drivers'                            => $stashPrefix . '/Drivers.php',
    'ehough_stash_exception_Exception'                => $stashPrefix . '/exception/Exception.php',
    'ehough_stash_exception_InvalidArgumentException' => $stashPrefix . '/exception/InvalidArgumentException.php',
    'ehough_stash_exception_LogicException'           => $stashPrefix . '/exception/LogicException.php',
    'ehough_stash_exception_RuntimeException'         => $stashPrefix . '/exception/RuntimeException.php',
    'ehough_stash_Item'                               => $stashPrefix . '/Item.php',
    'ehough_stash_ItemInterface'                      => $stashPrefix . '/ItemInterface.php',
    'ehough_stash_Pool'                               => $stashPrefix . '/Pool.php',
    'ehough_stash_PoolInterface'                      => $stashPrefix . '/PoolInterface.php',
    'ehough_stash_Utilities'                          => $stashPrefix . '/Utilities.php',

    'ehough_tickertape_ContainerAwareEventDispatcher' => $tickerTapePrefix . '/ContainerAwareEventDispatcher.php',
    'ehough_tickertape_EventDispatcher'               => $tickerTapePrefix . '/EventDispatcher.php',
    'ehough_tickertape_EventDispatcherInterface'      => $tickerTapePrefix . '/EventDispatcherInterface.php',
    'ehough_tickertape_Event'                         => $tickerTapePrefix . '/Event.php',
    'ehough_tickertape_GenericEvent'                  => $tickerTapePrefix . '/GenericEvent.php',

    'org_tubepress_api_const_options_names_Meta' => $oldPrefix1 . '/tubepress/api/const/options/names/Meta.php',
    'org_tubepress_api_const_template_Variable'  => $oldPrefix1 . '/tubepress/api/const/template/Variable.php',
    'org_tubepress_template_Template'            => $oldPrefix1 . '/tubepress/template/Template.php',

    'tubepress_api_const_event_EventNames'                         => $apiPrefix . '/const/event/EventNames.php',
    'tubepress_api_const_options_names_Advanced'                   => $apiPrefix . '/const/options/names/Advanced.php',
    'tubepress_api_const_options_names_Cache'                      => $apiPrefix . '/const/options/names/Cache.php',
    'tubepress_api_const_options_names_Embedded'                   => $apiPrefix . '/const/options/names/Embedded.php',
    'tubepress_api_const_options_names_Feed'                       => $apiPrefix . '/const/options/names/Feed.php',
    'tubepress_api_const_options_names_InteractiveSearch'          => $apiPrefix . '/const/options/names/InteractiveSearch.php',
    'tubepress_api_const_options_names_Meta'                       => $apiPrefix . '/const/options/names/Meta.php',
    'tubepress_api_const_options_names_OptionsUi'                  => $apiPrefix . '/const/options/names/OptionsUi.php',
    'tubepress_api_const_options_names_Output'                     => $apiPrefix . '/const/options/names/Output.php',
    'tubepress_api_const_options_names_Thumbs'                     => $apiPrefix . '/const/options/names/Thumbs.php',
    'tubepress_api_const_options_values_OrderByValue'              => $apiPrefix . '/const/options/values/OrderByValue.php',
    'tubepress_api_const_options_values_OutputValue'               => $apiPrefix . '/const/options/values/OutputValue.php',
    'tubepress_api_const_options_values_PerPageSortValue'          => $apiPrefix . '/const/options/values/PerPageSortValue.php',
    'tubepress_api_const_options_values_PlayerImplementationValue' => $apiPrefix . '/const/options/values/PlayerImplementationValue.php',
    'tubepress_api_const_template_Variable'                        => $apiPrefix . '/const/template/Variable.php',
    'tubepress_api_event_EventDispatcherInterface'                 => $apiPrefix . '/event/EventDispatcherInterface.php',
    'tubepress_api_event_EventInterface'                           => $apiPrefix . '/event/EventInterface.php',
    'tubepress_api_ioc_CompilerPassInterface'                      => $apiPrefix . '/ioc/CompilerPassInterface.php',
    'tubepress_api_ioc_ContainerExtensionInterface'                => $apiPrefix . '/ioc/ContainerExtensionInterface.php',
    'tubepress_api_ioc_ContainerInterface'                         => $apiPrefix . '/ioc/ContainerInterface.php',
    'tubepress_api_ioc_DefinitionInterface'                        => $apiPrefix . '/ioc/DefinitionInterface.php',
    'tubepress_api_video_VideoGalleryPage'                         => $apiPrefix . '/video/VideoGalleryPage.php',
    'tubepress_api_video_Video'                                    => $apiPrefix . '/video/Video.php',

    'tubepress_impl_addon_AddonBase'                                      => $implPrefix . '/addon/AddonBase.php',
    'tubepress_impl_boot_AbstractCachingBootHelper'                       => $implPrefix . '/boot/AbstractCachingBootHelper.php',
    'tubepress_impl_boot_DefaultAddonBooter'                              => $implPrefix . '/boot/DefaultAddonBooter.php',
    'tubepress_impl_boot_DefaultAddonDiscoverer'                          => $implPrefix . '/boot/DefaultAddonDiscoverer.php',
    'tubepress_impl_boot_DefaultBootConfigService'                        => $implPrefix . '/boot/DefaultBootConfigService.php',
    'tubepress_impl_boot_DefaultClassLoadingHelper'                       => $implPrefix . '/boot/DefaultClassLoadingHelper.php',
    'tubepress_impl_boot_DefaultIocContainerBootHelper'                   => $implPrefix . '/boot/DefaultIocContainerBootHelper.php',
    'tubepress_impl_cache_ItemDecorator'                                  => $implPrefix . '/cache/ItemDecorator.php',
    'tubepress_impl_cache_PoolDecorator'                                  => $implPrefix . '/cache/PoolDecorator.php',
    'tubepress_impl_collector_DefaultVideoCollector'                      => $implPrefix . '/collector/DefaultVideoCollector.php',
    'tubepress_impl_context_MemoryExecutionContext'                       => $implPrefix . '/context/MemoryExecutionContext.php',
    'tubepress_impl_embedded_DefaultEmbeddedPlayerHtmlGenerator'          => $implPrefix . '/embedded/DefaultEmbeddedPlayerHtmlGenerator.php',
    'tubepress_impl_embedded_EmbeddedPlayerUtils'                         => $implPrefix . '/embedded/EmbeddedPlayerUtils.php',
    'tubepress_impl_environment_SimpleEnvironmentDetector'                => $implPrefix . '/environment/SimpleEnvironmentDetector.php',
    'tubepress_impl_event_DefaultEventDispatcher'                         => $implPrefix . '/event/DefaultEventDispatcher.php',
    'tubepress_impl_event_TickertapeEventWrapper'                         => $implPrefix . '/event/TickertapeEventWrapper.php',
    'tubepress_impl_feed_CacheAwareFeedFetcher'                           => $implPrefix . '/feed/CacheAwareFeedFetcher.php',
    'tubepress_impl_html_CssAndJsRegistry'                                => $implPrefix . '/html/CssAndJsRegistry.php',
    'tubepress_impl_html_CssAndJsHtmlGenerator'                           => $implPrefix . '/html/CssAndJsHtmlGenerator.php',
    'tubepress_impl_http_AbstractPluggableAjaxCommandService'             => $implPrefix . '/http/AbstractPluggableAjaxCommandService.php',
    'tubepress_impl_http_DefaultAjaxHandler'                              => $implPrefix . '/http/DefaultAjaxHandler.php',
    'tubepress_impl_http_DefaultHttpRequestParameterService'              => $implPrefix . '/http/DefaultHttpRequestParameterService.php',
    'tubepress_impl_http_DefaultResponseCodeHandler'                      => $implPrefix . '/http/DefaultResponseCodeHandler.php',
    'tubepress_impl_ioc_ChainRegistrar'                                   => $implPrefix . '/ioc/ChainRegistrar.php',
    'tubepress_impl_ioc_CoreIocContainer'                                 => $implPrefix . '/ioc/CoreIocContainer.php',
    'tubepress_impl_ioc_Definition'                                       => $implPrefix . '/ioc/Definition.php',
    'tubepress_impl_ioc_IconicContainer'                                  => $implPrefix . '/ioc/IconicContainer.php',
    'tubepress_impl_ioc_IconicDefinitionWrapper'                          => $implPrefix . '/ioc/IconicDefinitionWrapper.php',
    'tubepress_impl_ioc_Reference'                                        => $implPrefix . '/ioc/Reference.php',
    'tubepress_impl_listeners_video_AbstractVideoConstructionListener'    => $implPrefix . '/listeners/video/AbstractVideoConstructionListener.php',
    'tubepress_impl_options_AbstractStorageManager'                       => $implPrefix . '/options/AbstractStorageManager.php',
    'tubepress_impl_options_DefaultOptionDescriptorReference'             => $implPrefix . '/options/DefaultOptionDescriptorReference.php',
    'tubepress_impl_options_DefaultOptionValidator'                       => $implPrefix . '/options/DefaultOptionValidator.php',
    'tubepress_impl_options_ui_BaseOptionsPageParticipant'                => $implPrefix . '/options/ui/BaseOptionsPageParticipant.php',
    'tubepress_impl_options_ui_DefaultOptionsPage'                        => $implPrefix . '/options/ui/DefaultOptionsPage.php',
    'tubepress_impl_options_ui_OptionsPageItem'                           => $implPrefix . '/options/ui/OptionsPageItem.php',
    'tubepress_impl_options_ui_fields_AbstractMultiSelectField'           => $implPrefix . '/options/ui/fields/AbstractMultiSelectField.php',
    'tubepress_impl_options_ui_fields_AbstractOptionDescriptorBasedField' => $implPrefix . '/options/ui/fields/AbstractOptionDescriptorBasedField.php',
    'tubepress_impl_options_ui_fields_AbstractOptionsPageField'           => $implPrefix . '/options/ui/fields/AbstractOptionsPageField.php',
    'tubepress_impl_options_ui_fields_AbstractTemplateBasedOptionsPageField' => $implPrefix . '/options/ui/fields/AbstractTemplateBasedOptionsPageField.php',
    'tubepress_impl_options_ui_fields_BooleanField'                       => $implPrefix . '/options/ui/fields/BooleanField.php',
    'tubepress_impl_options_ui_fields_HiddenField'                        => $implPrefix . '/options/ui/fields/HiddenField.php',
    'tubepress_impl_options_ui_fields_SpectrumColorField'                 => $implPrefix . '/options/ui/fields/SpectrumColorField.php',
    'tubepress_impl_options_ui_fields_DropdownField'                      => $implPrefix . '/options/ui/fields/DropdownField.php',
    'tubepress_impl_options_ui_fields_TextField'                          => $implPrefix . '/options/ui/fields/TextField.php',
    'tubepress_impl_patterns_sl_ServiceLocator'                           => $implPrefix . '/patterns/sl/ServiceLocator.php',
    'tubepress_impl_player_DefaultPlayerHtmlGenerator'                    => $implPrefix . '/player/DefaultPlayerHtmlGenerator.php',
    'tubepress_impl_provider_AbstractPluggableVideoProviderService'       => $implPrefix . '/provider/AbstractPluggableVideoProviderService.php',
    'tubepress_impl_querystring_SimpleQueryStringService'                 => $implPrefix . '/querystring/SimpleQueryStringService.php',
    'tubepress_impl_shortcode_DefaultShortcodeHtmlGenerator'              => $implPrefix . '/shortcode/DefaultShortcodeHtmlGenerator.php',
    'tubepress_impl_shortcode_SimpleShortcodeParser'                      => $implPrefix . '/shortcode/SimpleShortcodeParser.php',
    'tubepress_impl_theme_SimpleThemeHandler'                             => $implPrefix . '/theme/SimpleThemeHandler.php',
    'tubepress_impl_util_LangUtils'                                       => $implPrefix . '/util/LangUtils.php',
    'tubepress_impl_util_StringUtils'                                     => $implPrefix . '/util/StringUtils.php',
    'tubepress_impl_util_TimeUtils'                                       => $implPrefix . '/util/TimeUtils.php',

    'tubepress_plugins_vimeo_api_const_options_names_Meta'   => $oldPrefix2 . '/vimeo/api/const/options/names/Meta.php',
    'tubepress_plugins_youtube_api_const_options_names_Meta' => $oldPrefix2 . '/youtube/api/const/options/names/Meta.php',

    'tubepress_spi_addon_Addon'                                => $spiPrefix . '/addon/Addon.php',
    'tubepress_spi_boot_AddonBooter'                           => $spiPrefix . '/boot/AddonBooter.php',
    'tubepress_spi_boot_AddonDiscoverer'                       => $spiPrefix . '/boot/AddonDiscoverer.php',
    'tubepress_spi_collector_VideoCollector'                   => $spiPrefix . '/collector/VideoCollector.php',
    'tubepress_spi_const_http_ParamName'                       => $spiPrefix . '/const/http/ParamName.php',
    'tubepress_spi_context_ExecutionContext'                   => $spiPrefix . '/context/ExecutionContext.php',
    'tubepress_spi_embedded_EmbeddedHtmlGenerator'             => $spiPrefix . '/embedded/EmbeddedHtmlGenerator.php',
    'tubepress_spi_embedded_PluggableEmbeddedPlayerService'    => $spiPrefix . '/embedded/PluggableEmbeddedPlayerService.php',
    'tubepress_spi_environment_EnvironmentDetector'            => $spiPrefix . '/environment/EnvironmentDetector.php',
    'tubepress_spi_event_EventBase'                            => $spiPrefix . '/event/EventBase.php',
    'tubepress_spi_feed_FeedFetcher'                           => $spiPrefix . '/feed/FeedFetcher.php',
    'tubepress_spi_html_CssAndJsRegistryInterface'             => $spiPrefix . '/html/CssAndJsRegistryInterface.php',
    'tubepress_spi_html_CssAndJsHtmlGeneratorInterface'        => $spiPrefix . '/html/CssAndJsHtmlGeneratorInterface.php',
    'tubepress_spi_http_AjaxHandler'                           => $spiPrefix . '/http/AjaxHandler.php',
    'tubepress_spi_http_HttpRequestParameterService'           => $spiPrefix . '/http/HttpRequestParameterService.php',
    'tubepress_spi_http_PluggableAjaxCommandService'           => $spiPrefix . '/http/PluggableAjaxCommandService.php',
    'tubepress_spi_http_ResponseCodeHandler'                   => $spiPrefix . '/http/ResponseCodeHandler.php',
    'tubepress_spi_message_MessageService'                     => $spiPrefix . '/message/MessageService.php',
    'tubepress_spi_options_OptionDescriptor'                   => $spiPrefix . '/options/OptionDescriptor.php',
    'tubepress_spi_options_OptionDescriptorReference'          => $spiPrefix . '/options/OptionDescriptorReference.php',
    'tubepress_spi_options_OptionValidator'                    => $spiPrefix . '/options/OptionValidator.php',
    'tubepress_spi_options_StorageManager'                     => $spiPrefix . '/options/StorageManager.php',
    'tubepress_spi_options_PluggableOptionDescriptorProvider'  => $spiPrefix . '/options/PluggableOptionDescriptorProvider.php',
    'tubepress_spi_options_ui_OptionsPageFieldInterface'       => $spiPrefix . '/options/ui/OptionsPageFieldInterface.php',
    'tubepress_spi_options_ui_OptionsPageInterface'            => $spiPrefix . '/options/ui/OptionsPageInterface.php',
    'tubepress_spi_options_ui_OptionsPageItemInterface'        => $spiPrefix . '/options/ui/OptionsPageItemInterface.php',
    'tubepress_spi_options_ui_PluggableOptionsPageParticipantInterface' => $spiPrefix . '/options/ui/PluggableOptionsPageParticipantInterface.php',
    'tubepress_spi_player_PlayerHtmlGenerator'                 => $spiPrefix . '/player/PlayerHtmlGenerator.php',
    'tubepress_spi_player_PluggablePlayerLocationService'      => $spiPrefix . '/player/PluggablePlayerLocationService.php',
    'tubepress_spi_provider_PluggableVideoProviderService'     => $spiPrefix . '/provider/PluggableVideoProviderService.php',
    'tubepress_spi_provider_UrlBuilder'                        => $spiPrefix . '/provider/UrlBuilder.php',
    'tubepress_spi_querystring_QueryStringService'             => $spiPrefix . '/querystring/QueryStringService.php',
    'tubepress_spi_shortcode_PluggableShortcodeHandlerService' => $spiPrefix . '/shortcode/PluggableShortcodeHandlerService.php',
    'tubepress_spi_shortcode_ShortcodeHtmlGenerator'           => $spiPrefix . '/shortcode/ShortcodeHtmlGenerator.php',
    'tubepress_spi_shortcode_ShortcodeParser'                  => $spiPrefix . '/shortcode/ShortcodeParser.php',
    'tubepress_spi_theme_ThemeHandler'                         => $spiPrefix . '/theme/ThemeHandler.php',
    'tubepress_spi_version_Version'                            => $spiPrefix . '/version/Version.php',
);