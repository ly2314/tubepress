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
  * @package TubePress\IOC
  */
interface tubepress_api_ioc_ContainerBuilderInterface
{
    const _ = 'tubepress_api_ioc_ContainerBuilderInterface';

    /**
     * Adds the service definitions.
     *
     * @param tubepress_api_ioc_DefinitionInterface[] An array of service definitions
     *
     * @return void
     *
     * @api
     * @since 3.1.0
     */
    function addDefinitions(array $definitions);

    /**
     * Returns service ids for a given tag.
     *
     * @param string The tag name
     *
     * @return array An array of tags
     *
     * @api
     * @since 3.1.0
     */
    function findTaggedServiceIds($name);

    /**
     * Returns all tags the defined services use.
     *
     * @return array An array of tags
     *
     * @api
     * @since 3.1.0
     */
    function findTags();

    /**
     * Gets a service.
     *
     * @param string The service identifier
     *
     * @return object The associated service, or null if not defined.
     *
     * @api
     * @since 3.1.0
     */
    function get($id);

    /**
     * Gets a service definition.
     *
     * @param string The service identifier
     *
     * @return tubepress_api_ioc_DefinitionInterface A `tubepress_api_ioc_DefinitionInterface` instance, or null if the
     *                                               service does not exist.
     *
     * @api
     * @since 3.1.0
     */
    function getDefinition($id);

    /**
     * Gets all service definitions.
     *
     * @return tubepress_api_ioc_DefinitionInterface[] An array of `tubepress_api_ioc_DefinitionInterface` instances
     *
     * @api
     * @since 3.1.0
     */
    function getDefinitions();

    /**
     * Gets a parameter.
     *
     * @param string The parameter name
     *
     * @return mixed The parameter value
     *
     * @throws InvalidArgumentException if the parameter is not defined
     *
     * @api
     * @since 3.1.0
     */
    function getParameter($name);

    /**
     * Gets all service ids.
     *
     * @return array An array of all defined service ids
     *
     * @api
     * @since 3.1.0
     */
    function getServiceIds();

    /**
     * Returns true if the given service is defined.
     *
     * @param string The service identifier
     *
     * @return Boolean true if the service is defined, false otherwise
     *
     * @api
     * @since 3.1.0
     */
    function has($id);

    /**
     * Returns true if a service definition exists under the given identifier.
     *
     * @param string The service identifier
     *
     * @return Boolean true if the service definition exists, false otherwise
     *
     * @api
     * @since 3.1.0
     */
    function hasDefinition($id);

    /**
     * Checks if a parameter exists.
     *
     * @param string The parameter name
     *
     * @return Boolean The presence of parameter in container
     *
     * @api
     * @since 3.1.0
     */
    function hasParameter($name);

    /**
     * Check for whether or not a service has been initialized.
     *
     * @param string Name of the service to be verified
     *
     * @return Boolean true if the service has been initialized, false otherwise
     *
     * @api
     * @since 3.1.0
     */
    function initialized($id);

    /**
     * Registers a service definition.
     *
     * This methods allows for simple registration of service definition
     * with a fluid interface.
     *
     * @param string The service identifier
     * @param string The service class
     *
     * @return tubepress_api_ioc_DefinitionInterface A `tubepress_api_ioc_DefinitionInterface` instance
     *
     * @api
     * @since 3.1.0
     */
    function register($id, $class = null);

    /**
     * Removes a service definition.
     *
     * @param string The service identifier
     *
     * @return void
     *
     * @api
     * @since 3.1.0
     */
    function removeDefinition($id);

    /**
     * Sets a service.
     *
     * @param string The service identifier
     * @param object The service instance
     *
     * @return void
     *
     * @api
     * @since 3.1.0
     */
    function set($id, $service);

    /**
     * Sets a service definition.
     *
     * @param string                                The service identifier
     * @param tubepress_api_ioc_DefinitionInterface A `tubepress_api_ioc_DefinitionInterface` instance
     *
     * @return tubepress_api_ioc_DefinitionInterface the service definition
     *
     * @throws BadMethodCallException When this ContainerBuilder is frozen
     *
     * @api
     * @since 3.1.0
     */
    function setDefinition($id, tubepress_api_ioc_DefinitionInterface $definition);

    /**
     * Sets the service definitions.
     *
     * @param tubepress_api_ioc_DefinitionInterface[] An array of service definitions
     *
     * @return void
     *
     * @api
     * @since 3.1.0
     */
    function setDefinitions(array $definitions);

    /**
     * Sets a parameter.
     *
     * @param string The parameter name
     * @param mixed  The parameter value
     *
     * @return void
     *
     * @api
     * @since 3.1.0
     */
    function setParameter($name, $value);
}