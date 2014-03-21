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
 * The dispatcher that passes events around during TubePress's execution. Typically instantiated
 * only once during execution, allows plug-ins to listen for and respond to specific events 
 * occuring during different phases of TubePress code execution.
 *
 * @package TubePress\API\Event
 */
interface tubepress_api_event_EventDispatcherInterface
{
    const _ = 'tubepress_api_event_EventDispatcherInterface';

    /**
     * Adds an event listener that listens on the specified events.
     *
     * @param string   The event to listen on
     * @param callable The listener
     * @param integer  The higher this value, the earlier an event
     *                 listener will be triggered in the chain (defaults to 0)
     *
     * @api
     * @since 3.1.0
     */
    function addListener($eventName, $listener, $priority = 0);

    /**
     * Adds a service as event listener
     *
     * @param string Event for which the listener is added
     * @param array  The service ID of the listener service & the method
     *               name that has to be called
     * @param integer The higher this value, the earlier an event listener
     *               will be triggered in the chain. Defaults to 0.
     *
     * @throws InvalidArgumentException
     *
     * @api
     * @since 3.1.0
     */
    function addListenerService($eventName, $callback, $priority = 0);

    /**
     * Dispatches an event to all registered listeners.
     *
     * @param string The name of the event to dispatch. The name of
     *               the event is the name of the method that is
     *               invoked on listeners.
     * @param tubepress_api_event_EventInterface The event to pass to the event handlers/listeners.
     *               If not supplied, an empty event instance is created.
     *
     * @return tubepress_api_event_EventInterface
     *
     * @api
     * @since 3.1.0
     */
    function dispatch($eventName, tubepress_api_event_EventInterface $event = null);

    /**
     * Gets the listeners of a specific event or all listeners.
     *
     * @param string The name of the event
     *
     * @return array The event listeners for the specified event, or all event listeners by event name
     *
     * @api
     * @since 3.1.0
     */
    function getListeners($eventName = null);

    /**
     * Checks whether an event has any registered listeners.
     *
     * @param string The name of the event
     *
     * @return Boolean true if the specified event has any listeners, false otherwise
     *
     * @api
     * @since 3.1.0
     */
    function hasListeners($eventName = null);

    /**
     * Removes an event listener from the specified events.
     *
     * @param string|array The event(s) to remove a listener from
     * @param callable     The listener to remove
     *
     * @api
     * @since 3.1.0
     */
    function removeListener($eventName, $listener);
}
