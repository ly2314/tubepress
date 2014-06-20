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
 * Adds shortcode handlers to TubePress.
 */
class tubepress_core_cache_impl_stash_FilesystemCacheBuilder
{
    /**
     * @var tubepress_core_options_api_ContextInterface
     */
    private $_context;

    /**
     * @var ehough_filesystem_FilesystemInterface
     */
    private $_filesystem;

    public function __construct(tubepress_core_options_api_ContextInterface $context,
                                ehough_filesystem_FilesystemInterface       $fs)
    {
        $this->_context    = $context;
        $this->_filesystem = $fs;
    }

    public function buildFilesystemDriver()
    {
        $dir = $this->_context->get(tubepress_core_cache_api_Constants::DIRECTORY);

        /**
         * If a path was given, but it's not a directory, let's try to create it.
         */
        if ($dir != '' && !is_dir($dir)) {

            @mkdir($dir, 0755, true);
        }

        /**
         * If the directory exists, but isn't writable, let's try to change that.
         */
        if (is_dir($dir) && !is_writable($dir)) {

            @chmod($dir, 0755);
        }

        /**
         * If we don't have a writable directory, use the system temp directory.
         */
        if (!is_dir($dir) || !is_writable($dir)) {

            $dir = $this->_filesystem->getSystemTempDirectory() . DIRECTORY_SEPARATOR . 'tubepress-api-cache';
        }

        $driver = new ehough_stash_driver_FileSystem();
        $driver->setOptions(array('path' => $dir));

        return $driver;
    }
}