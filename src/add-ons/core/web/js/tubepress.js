/*!
 * Copyright 2006 - 2014 TubePress LLC (http://tubepress.com).
 * This file is part of TubePress (http://tubepress.com).
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/*global jQuery, console */
/*jslint devel: true, browser: true, sloppy: false, white: true, maxerr: 50, indent: 4 */

/**
 * This file serves as the core of TubePress's JavaScript presence. It contains
 *
 *  1. Utility functions, mostly to help with language and runtime tasks.
 *  2. An event bus.
 *  3. Functions to asychronously load other TubePress scripts as needed.
 */

/**
 * IE8 and below forces us to declare these now.
 *
 * http://tobyho.com/2013/03/13/window-prop-vs-global-var/
 */
var tubePressDomInjector,
    tubePressBeacon,

    TubePress = (function (jquery, win) {

    /** http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/ */
    'use strict';

    /**
     * Let's start with some variable declarations to help us with compression.
     */
    var text_tubepress      = 'tubepress',
        text_urls           = 'urls',
        text_base           = 'base',
        text_sys            = 'sys',
        text_src            = 'src',
        text_js             = 'js',
        text_gallery        = 'gallery',
        text_html           = 'html',
        text_error          = 'error',
        text_web            = 'web',
        text_path_separator = '/',
        windowLocation      = win.location,
        dokument            = win.document,
        troo                = true,
        jquery_isFunction   = jquery.isFunction,
        nulll               = null,
        fawlse              = false,

        /**
         * Random language utilities.
         */
        langUtils = (function () {

            var isDefined = function (obj) {

                return typeof obj !== 'undefined';
            },

                getParameterByName = function (name) {

                    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");

                    var regexS  = "[\\?&]" + name + "=([^&#]*)",
                        regex   = new RegExp(regexS),
                        results = regex.exec(windowLocation.search);

                    return results === nulll ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                },

                parseIntOrZero = function (candidate) {

                    var firstPass = parseInt(candidate, 10);

                    return isNaN(firstPass) ? 0 : firstPass;
                },

                /**
                 * Utility to wait for test() to be true, then call callback()
                 */
                callWhenTrue = function (callback, test, delay) {

                    /** It's ready... */
                    if (test() === troo) {

                        callback();

                        return;
                    }

                    /** Set up a timeout callback. */
                    var func = function () {

                        callWhenTrue(callback, test, delay);
                    };

                    /** Keep waiting... */
                    setTimeout(func, delay);
                },

                //http://stackoverflow.com/questions/2631001/javascript-test-for-existence-of-nested-object-key
                hasOwnNestedProperty = function (o) {

                    if (!o) {

                        return fawlse;
                    }

                    var args = Array.prototype.slice.call(arguments),
                        obj  = args.shift(),
                        i;

                    for (i = 0; i < args.length; i += 1) {

                        if (!obj.hasOwnProperty(args[i])) {

                            return fawlse;
                        }

                        obj = obj[args[i]];
                    }

                    return true;
                },

                trimSlashes = function (haystack, leading) {

                    if (leading) {

                        return haystack.replace(/^\/+/, '');
                    }

                    return haystack.replace(/\/+$/, '');
                };

            return {

                isDefined            : isDefined,
                getParameterByName   : getParameterByName,
                parseIntOrZero       : parseIntOrZero,
                callWhenTrue         : callWhenTrue,
                hasOwnNestedProperty : hasOwnNestedProperty,
                trimSlashes          : trimSlashes
            };
        }()),

        /**
         * Logger!
         */
        logger = (function () {

            /**
             * Is the log on?
             */
            var isLoggingRequested = windowLocation.search.indexOf(text_tubepress + '_debug=true') !== -1,
                windowConsole      = win.console,
                isLoggingAvailable = langUtils.isDefined(windowConsole),

                /**
                 * The log is on if it's been enabled and requested.
                 */
                isLoggingOn = function () {

                    return isLoggingRequested && isLoggingAvailable;
                },

                /**
                 * Output a message.
                 */
                log = function (msg) {

                    windowConsole.log(text_tubepress + ': ' + msg);
                },

                dir = function (obj) {

                    windowConsole.dir(obj);
                };

            return {

                on  : isLoggingOn,
                log : log,
                dir : dir
            };
        }()),

        /**
         * Details about our environment.
         */
        environment = (function () {

            var alreadyCalculatedBaseUrl = fawlse,
                text_usr                 = 'usr',
                cachedBaseUrl,

                getJsConfig = function () {

                    return win.TubePressJsConfig;
                },

                getBaseUrl = function () {

                    var tubePressJsConfig = getJsConfig(),
                        scripts, x, scriptSrc;

                    if (!alreadyCalculatedBaseUrl) {

                        if (langUtils.hasOwnNestedProperty(tubePressJsConfig, text_urls, text_base)) {

                            cachedBaseUrl = langUtils.trimSlashes(tubePressJsConfig[text_urls][text_base], fawlse);

                        } else {

                            //http://stackoverflow.com/questions/2161159/get-script-path
                            dokument.getElementsByTagName('script');
                            x       = 0;

                            for (x; x < scripts.length; x += 1) {

                                scriptSrc = scripts[x][text_src];

                                if (scriptSrc.indexOf(text_path_separator + text_tubepress + '.js') !== -1) {

                                    cachedBaseUrl = langUtils.trimSlashes(
                                        scriptSrc.substr(0, scriptSrc.lastIndexOf(text_path_separator))
                                            .split('?')[0]
                                            .replace(text_web + '/js', '')
                                        , fawlse);
                                    break;
                                }
                            }
                        }

                        alreadyCalculatedBaseUrl = troo;
                    }

                    return cachedBaseUrl;
                },

                getAjaxEndpointUrl = function () {

                    var text_ajaxEndpoint = 'ajaxEndpoint',
                        text_php          = 'php',
                        tubePressJsConfig = getJsConfig();

                    if (langUtils.hasOwnNestedProperty(tubePressJsConfig, text_urls, text_php, text_sys, text_ajaxEndpoint)) {

                        return tubePressJsConfig[text_urls][text_php][text_sys][text_ajaxEndpoint];

                    }

                    return getBaseUrl() + text_path_separator + text_src + '/core/http/web/php/' + text_ajaxEndpoint + '.php';
                },

                getUserContentUrl = function () {

                    var tubePressJsConfig = getJsConfig();

                    if (langUtils.hasOwnNestedProperty(tubePressJsConfig, text_urls, text_usr)) {

                        return tubePressJsConfig[text_urls][text_usr];
                    }

                    return getBaseUrl() + text_path_separator + text_tubepress + '-content';
                };

            return {

                getBaseUrl         : getBaseUrl,
                getAjaxEndpointUrl : getAjaxEndpointUrl,
                getUserContentUrl  : getUserContentUrl
            };
        }()),

        /**
         * Lightweight event bus for TubePress.
         *
         * https://gist.github.com/cowboy/661855
         *
         * jQuery Tiny Pub/Sub - v0.3 - 11/4/2010
         * http://benalman.com/
         *
         * Copyright (c) 2010 "Cowboy" Ben Alman
         * Dual licensed under the MIT and GPL licenses.
         * http://benalman.com/about/license/
         */
        beacon = (function () {

            var bus = jquery({}),

                subscribe = function () {

                    bus.on.apply(bus, arguments);
                },

                unsubscribe = function () {

                    bus.off.apply(bus, arguments);
                },

                publish = function () {

                    if (logger.on()) {

                        var args = arguments;

                        logger.log('firing event ' + args[0]);

                        if (args.length > 1) {

                            logger.dir(args[1]);
                        }
                    }

                    bus.trigger.apply(bus, arguments);
                };

            return {

                subscribe   : subscribe,
                unsubscribe : unsubscribe,
                publish     : publish
            };
        }()),

        /**
         * Injects JS and CSS into the DOM.
         */
        domInjector = (function () {

            var filesAlreadyLoaded = [],

                alreadyLoaded = function (path) {

                    return filesAlreadyLoaded[path] === troo;
                },

                convertToAbsoluteUrl = function (url, isSystem) {

                    if (url.indexOf(text_path_separator) === 0 || url.indexOf('http') === 0) {

                        //already absolute
                        return url;
                    }

                    var prefix;

                    if (isSystem) {

                        prefix = environment.getBaseUrl();

                    } else {

                        prefix = environment.getUserContentUrl();
                    }

                    return prefix + text_path_separator + langUtils.trimSlashes(url, true);
                },

                doLog = function (path, type) {

                    if (logger.on()) {

                        logger.log('Injecting ' + type + ': ' + path);
                    }
                },

                appendToHead = function (element) {

                    dokument.getElementsByTagName('head')[0].appendChild(element);
                },

                loadCss = function (path, isSystem) {

                    isSystem = langUtils.isDefined(isSystem) ? isSystem : true;

                    path = convertToAbsoluteUrl(path, isSystem);

                    if (alreadyLoaded(path)) {

                        return;
                    }

                    filesAlreadyLoaded[path] = troo;

                    var fileref   = dokument.createElement('link');

                    fileref.rel  = 'stylesheet';
                    fileref.type = 'text/css';
                    fileref.href = path;

                    doLog(path, 'CSS');

                    appendToHead(fileref);
                },

                loadJs = function (path, isSystem) {

                    isSystem = langUtils.isDefined(isSystem) ? isSystem : true;

                    path = convertToAbsoluteUrl(path, isSystem);

                    if (alreadyLoaded(path)) {

                        return;
                    }

                    filesAlreadyLoaded[path] = troo;

                    doLog(path, 'JS');

                    var script = dokument.createElement('script');

                    script.type      = 'text/javascript';
                    script[text_src] = path;
                    script.async     = troo;

                    dokument.getElementsByTagName('head')[0].appendChild(script);
                },

                loadSystemScript = function (scriptName) {

                    var tubePressJsConfig = win.TubePressJsConfig;

                    if (langUtils.hasOwnNestedProperty(tubePressJsConfig, text_urls, text_js, text_sys, scriptName)) {

                        loadJs(tubePressJsConfig[text_urls][text_js][text_sys][scriptName]);

                    } else {

                        loadJs(text_web + text_path_separator + text_js + text_path_separator + scriptName + '.js');
                    }
                },

                loadGalleryJs = function () {

                    loadSystemScript(text_gallery);
                },

                loadPlayerApiJs = function () {

                    loadSystemScript('playerApi');
                },

                loadAjaxSearchJs = function () {

                    loadSystemScript('ajaxSearch');
                };

            return {

                loadJs           : loadJs,
                loadCss          : loadCss,
                loadGalleryJs    : loadGalleryJs,
                loadPlayerApiJs  : loadPlayerApiJs,
                loadAjaxSearchJs : loadAjaxSearchJs
            };
        }()),

        /**
         * Core of our asychronous APIs.
         */
        asyncConverter = (function () {

            //http://tmxcredit.com/tech-blog/understanding-javascript-asynchronous-apis/
            var convertQueueToFunctionCalls = function (asyncObjectName, delegate) {

                var loggerOn = logger.on(),
                    queueLength,

                    queue = win[asyncObjectName],

                    queueCall = function (callArray) {

                        var method = callArray[0],
                            args   = callArray.slice(1);

                        delegate[method].apply(this, args);
                    };

                if (langUtils.isDefined(queue)) {

                    queueLength = queue.length;

                    if (loggerOn) {

                        logger.log('Running ' + queueLength + ' queue items for ' + asyncObjectName);
                    }

                    // loop through our existing queue, calling methods in order
                    queue.reverse();

                    while (queue.length) {

                        queueCall(queue.pop());
                    }
                }

                if (loggerOn) {

                    logger.log(asyncObjectName + ' is now connected');
                }

                // over write the sampleQueue, replacing the push method with 'queueCall'
                // this creates a globally accessible interface to your API through sampleQueue.push()
                win[asyncObjectName] = {

                    push : queueCall
                };
            };

            return {

                processQueueCalls : convertQueueToFunctionCalls
            };
        }()),

        /**
         * Handles styling DOM elements before and after loads.
         */
        loadStyler = (function () {

            /**
             * Fade to "white".
             */
            var applyLoadingStyle = function (targetDiv) {

                    jquery(targetDiv).fadeTo(0, 0.3);
                },

                /**
                 * Fade back to full opacity.
                 */
                removeLoadingStyle = function (targetDiv) {

                    jquery(targetDiv).fadeTo(0, 1);
                };

            return {

                applyLoadingStyle  : applyLoadingStyle,
                removeLoadingStyle : removeLoadingStyle
            };
        }()),

        /**
         * Various Ajax utilities.
         */
        ajaxExecutor = (function () {

            var doAjax = function (dataToSend) {

                beacon.publish(text_tubepress + '.ajax', dataToSend);

                jquery.ajax(dataToSend);
            },

                errorLogger = function (jqxhr, message, error) {

                    if (logger.on()) {

                        logger.log('Ajax error: ' + message);
                    }
                },

                getErrorHandler = function (data) {

                    if (!langUtils.isDefined(data[text_error])) {

                        return errorLogger;
                    }

                    return function (jqxhr, message, error) {

                        errorLogger(jqxhr, message, error);
                        data[text_error](jqxhr, message, error);
                    };
                },

                /**
                 * Similar to jQuery's "load" but tolerates non-200 status codes.
                 * https://github.com/jquery/jquery/blob/1.8-stable/src/ajax.js#L203
                 */
                load = function (method, url, targetDiv, selector, preLoadFunction, postLoadFunction) {

                var rscript = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,

                    completeCallback = function (res) {

                        var responseText = res.responseText,
                            html         = selector ? jquery('<div>').append(responseText.replace(rscript, '')).find(selector) : responseText;

                        jquery(targetDiv).html(html);

                        /* did the user supply a post-load function? */
                        if (jquery_isFunction(postLoadFunction)) {

                            postLoadFunction();
                        }
                    }, dataToSend = {

                        url      : url,
                        type     : method,
                        dataType : 'html',
                        complete : completeCallback
                    };

                /** did the user supply a pre-load function? */
                if (jquery_isFunction(preLoadFunction)) {

                    preLoadFunction();
                }

                doAjax(dataToSend);
            },

            get = function (method, url, data, success, dataType) {

                var dataToSend = {

                    url      : url,
                    type     : method,
                    data     : data,
                    dataType : dataType,
                    success  : success,
                    error    : getErrorHandler(data)
                };

                doAjax(dataToSend);
            },

            triggerDoneLoading = function (targetDiv) {

                loadStyler.removeLoadingStyle(targetDiv);
            },

            /**
             * Calls "load", but does some additional styling on the target element while it's processing.
             */
            loadAndStyle = function (method, url, targetDiv, selector, preLoadFunction, postLoadFunction) {

                /** one way or another, we're removing the loading style when we're done... */
                var post = function () {

                    triggerDoneLoading(targetDiv);
                };

                loadStyler.applyLoadingStyle(targetDiv);

                /** ... but maybe we want to do something else too */
                if (jquery_isFunction(postLoadFunction)) {

                    post = function () {

                        triggerDoneLoading(targetDiv);
                        postLoadFunction();
                    };
                }

                /** do the load. do it! */
                load(method, url, targetDiv, selector, preLoadFunction, post);
            };

            return {

                loadAndStyle : loadAndStyle,
                get          : get
            };
        }());

    /**
     * Handle window resize events.
     */
    (function () {

        var timeout,

            publishResizeEvent = function () {

                beacon.publish(text_tubepress + '.window.resize');
            },

            onBrowserResize = function () {

                clearTimeout(timeout);

                timeout = setTimeout(publishResizeEvent, 150);
            },

            init = function () {

                jquery(win).resize(onBrowserResize);
            };

        jquery(init);

    }());

    /**
     * Convert any queued calls to their real counterparts.
     */
    (function () {

        var textCamelCaseTubePress = 'tubePress';

        asyncConverter.processQueueCalls(textCamelCaseTubePress + 'DomInjector', domInjector);
        asyncConverter.processQueueCalls(textCamelCaseTubePress + 'Beacon', beacon);

    }());

    /**
     * Stuff we expose to everyone else.
     */
    return {

        Ajax : {

            Executor   : ajaxExecutor,
            LoadStyler : loadStyler
        },

        AsyncUtil   : asyncConverter,
        Beacon      : beacon,
        DomInjector : domInjector,
        Environment : environment,

        Lang : {

            Utils : langUtils
        },

        Logger : logger
    };

}(jQuery, window));