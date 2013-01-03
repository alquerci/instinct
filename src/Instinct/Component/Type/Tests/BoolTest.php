<?php
/**
 * The Instinct PHP framework
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (C) 2013  alexandre.quercia
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @author alexandre.quercia
 */

namespace Instinct\Component\Type\Tests;

use Instinct\Component\Type\Bool;

/**
 * @author alexandre.quercia
 * @since v0.0.1
 */
class BoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Bool
     */
    protected $var;

    public function setUp()
    {
        Bool::pnew($this->var);
    }

    public function tearDown()
    {
        $this->var = null;
    }

    public function testNew()
    {
        $this->assertInstanceOf("Instinct\Component\Type\Bool", $this->var);
        $this->assertFalse($this->var->toBoolean());
    }

    /**
     * @dataProvider dataToBoolean
     */
    public function testToBoolean($value, $expected)
    {
        $this->var = false;
        $this->var = $value;
        $this->assertInstanceOf("Instinct\Component\Type\Bool", $this->var);
        $this->assertSame($this->var->toBoolean(), $expected);
        $this->var = true;
        $this->var = $value;
        $this->assertInstanceOf("Instinct\Component\Type\Bool", $this->var);
        $this->assertSame($this->var->toBoolean(), $expected);
    }

    public function dataToBoolean()
    {
        return array(
                array(true, true),
                array(false, false),
                array(0, false),
                array(1, true),
                array(123, true),
                array(-123, true),
                array(array(), false),
                array(array("dfd"), true),
                array(0.0, false),
                array(0.123, true),
                array("dtgg", true),
                array("0", false),
                array($this, true),
                array(new \SimpleXMLElement("<a></a>"), false),
                array(new \SimpleXMLElement("<a>true</a>"), true),
                array(STDOUT, true),
            );
    }

}