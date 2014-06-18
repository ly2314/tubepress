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
 * Displays a standard text input.
 */
class tubepress_core_options_ui_impl_fields_provided_TextField extends tubepress_core_options_ui_impl_fields_provided_AbstractProvidedOptionBasedField
{
    /**
     * @var int The size of this text field.
     */
    private $_size = 20;

    public function setSize($size)
    {
        if (intval($size) < 1) {

            throw new InvalidArgumentException('Text fields must have a non-negative size.');
        }

        $this->_size = intval($size);
    }

    protected function getAdditionalTemplateVariables()
    {
        return array(

            'size' => $this->_size,
        );
    }

    protected function getAbsolutePathToTemplate()
    {
        return TUBEPRESS_ROOT . '/src/core/options-ui/resources/field-templates/text.tpl.php';
    }
}