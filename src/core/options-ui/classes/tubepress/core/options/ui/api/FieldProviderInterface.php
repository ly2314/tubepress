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
 * Major participant in the option page.
 *
 * @api
 * @since 4.0.0
 */
interface tubepress_core_options_ui_api_FieldProviderInterface extends tubepress_core_options_ui_api_ElementInterface
{
    /**
     * @return tubepress_core_options_ui_api_ElementInterface[] The categories that this participant supplies.
     *
     * @api
     * @since 4.0.0
     */
    function getCategories();

    /**
     * @return tubepress_core_options_ui_api_FieldInterface[] The fields that this options page participant provides.
     *
     * @api
     * @since 4.0.0
     */
    function getFields();

    /**
     * @return array An associative array, which may be empty, where the keys are category IDs and the values
     *               are arrays of field IDs that belong in the category.
     *
     * @api
     * @since 4.0.0
     */
    function getCategoryIdsToFieldIdsMap();

    /**
     * @return boolean True if this participant should show up in the "Only show options to..." dropdown. False otherwise.
     *
     * @api
     * @since 4.0.0
     */
    function isAbleToBeFilteredFromGui();

    /**
     * @return boolean True if this participant should separate its field into separate boxes. False otherwise.
     *
     * @api
     * @since 4.0.0
     */
    function fieldsShouldBeInSeparateBoxes();
}