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
 * @covers tubepress_impl_addon_AddonBase
 */
class tubepress_test_impl_addon_AddonBaseTest extends tubepress_test_TubePressUnitTest
{
    /**
     * @var tubepress_impl_addon_AddonBase
     */
    private $_sut;

    public function onSetup()
    {
        $this->_sut = new tubepress_impl_addon_AddonBase(

            'name',
            '2.3.1',
            'description',
            array('name' => 'eric', 'url' => 'http://foo.bar'),
            array(array('type' => 'foobar'))
        );
    }
    
    public function testGetSetClassMap()
    {
        $this->_sut->setClassMap(array('x' =>'y'));
        $this->assertEquals(array('x' => 'y'), $this->_sut->getClassMap());
    }

    public function testNonAssociativeClassMap()
    {
        $this->setExpectedException('InvalidArgumentException', 'Class map must be an associative array');

        $this->_sut->setClassMap(array('x'));
    }

    public function testNoStringClassMapPath()
    {
        $this->setExpectedException('InvalidArgumentException', 'Each classmap path must be a string');

        $this->_sut->setClassMap(array('x' => array()));
    }

    public function testSetIocContainerExtensionsNonString()
    {
        $this->setExpectedException('InvalidArgumentException', 'Each IoC container extension must be a string');

        $this->_sut->setExtensionClassNames(array(array()));
        $this->assertEquals(array(array()), $this->_sut->getExtensionClassNames());
    }

    public function testSetIocContainerExtensions()
    {
        $this->_sut->setExtensionClassNames(array('foo'));
        $this->assertEquals(array('foo'), $this->_sut->getExtensionClassNames());
    }

    public function testSetIocContainerCompilerPasses()
    {
        $this->_sut->setExtensionClassNames(array('foo'));
        $this->assertEquals(array('foo'), $this->_sut->getExtensionClassNames());
    }
    
    public function testSetPsr0NonString()
    {
        $this->setExpectedException('InvalidArgumentException', 'Each PSR-0 classpath root must be a string');

        $this->_sut->setPsr0ClassPathRoots(array(array()));
        $this->assertEquals(array(array()), $this->_sut->getPsr0ClassPathRoots());
    }

    public function testSetPsr0()
    {
        $this->_sut->setPsr0ClassPathRoots(array('foo'));
        $this->assertEquals(array('foo'), $this->_sut->getPsr0ClassPathRoots());
    }
}