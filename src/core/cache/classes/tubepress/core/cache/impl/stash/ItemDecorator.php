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
 * Decorates ehough_stash_Item to handle cache cleaning and TTL.
 */
class tubepress_core_cache_impl_stash_ItemDecorator implements ehough_stash_interfaces_ItemInterface
{
    /**
     * @var ehough_stash_interfaces_ItemInterface
     */
    private $_delegate;

    /**
     * @var ehough_stash_interfaces_PoolInterface
     */
    private $_parentCache;

    /**
     * @var tubepress_core_options_api_ContextInterface
     */
    private $_context;

    public function __construct(tubepress_core_options_api_ContextInterface $context,
                                ehough_stash_interfaces_ItemInterface       $delegate,
                                ehough_stash_interfaces_PoolInterface       $parentCache)
    {
        $this->_context     = $context;
        $this->_delegate    = $delegate;
        $this->_parentCache = $parentCache;
    }

    /**
     * Returns the key for the current cache item.
     *
     * The key is loaded by the Implementing Library, but should be available to
     * the higher level callers when needed.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->_delegate->getKey();
    }

    /**
     * Retrieves the item from the cache associated with this objects key.
     *
     * Value returned must be identical to the value original stored by set().
     *
     * If the cache is empty then null should be returned. However, null is also
     * a valid cache item, so the isMiss function should be used to check
     * validity.
     *
     * @return mixed
     */
    public function get($invalidation = 0, $arg = null, $arg2 = null)
    {
        return $this->_delegate->get($invalidation, $arg, $arg2);
    }

    /**
     * Stores a value into the cache.
     *
     * The $value argument can be any item that can be serialized by PHP,
     * although the method of serialization is left up to the Implementing
     * Library.
     *
     * The $ttl can be defined in a number of ways. As an integer or
     * DateInverval object the argument defines how long before the cache should
     * expire. As a DateTime object the argument defines the actual expiration
     * time of the object. Implementations are allowed to use a lower time than
     * passed, but should not use a longer one.
     *
     * If no $ttl is passed then the item can be stored indefinitely or a
     * default value can be set by the Implementing Library.
     *
     * Returns true if the item was successfully stored.
     *
     * @param mixed                     $value
     * @param int|DateInterval|DateTime $ttl
     *
     * @return bool
     */
    public function set($value, $ttl = null)
    {
        $cleaningFactor = $this->_context->get(tubepress_core_cache_api_Constants::CLEANING_FACTOR);
        $cleaningFactor = intval($cleaningFactor);

        /**
         * Handle cleaning factor.
         */
        if ($cleaningFactor > 0 && rand(1, $cleaningFactor) === 1) {

            $this->_parentCache->flush();
        }

        if ($ttl === null) {

            $ttl = intval($this->_context->get(tubepress_core_cache_api_Constants::LIFETIME_SECONDS));
        }

        return $this->_delegate->set($value, $ttl);
    }

    public function disable()
    {
        return $this->_delegate->disable();
    }

    public function clear()
    {
        return $this->_delegate->clear();
    }

    public function isMiss()
    {
        return $this->_delegate->isMiss();
    }

    public function lock($ttl = null)
    {
        return $this->_delegate->lock($ttl);
    }

    public function extend($ttl = null)
    {
        return $this->_delegate->extend($ttl);
    }

    public function isDisabled()
    {
        return $this->_delegate->isDisabled();
    }

    public function setLogger($logger)
    {
        $this->_delegate->setLogger($logger);
    }
}