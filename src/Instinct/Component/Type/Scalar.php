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

namespace Instinct\Component\Type;

/**
 * It used to enforce strong typing of the scalar type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Scalar extends Type implements ConvertibleInterface
{
    /**
     * @since v0.1
     *
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\ConvertibleInterface::toBoolean()
     *
     * @return boolean
     */
    public function toBoolean()
    {
        return (bool) $this->getValue();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\ConvertibleInterface::toInteger()
     *
     * @return number
     */
    public function toInteger()
    {
        return (integer) $this->getValue();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\ConvertibleInterface::toDouble()
     *
     * @return number
     */
    public function toDouble()
    {
        return (double) $this->getValue();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\ConvertibleInterface::toString()
     *
     * @return string
     */
    public function toString()
    {
        return (string) $this->getValue();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\ConvertibleInterface::toArray()
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this->getValue();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Object::equals()
     *
     * @param Object $obj
     * @return boolean
     */
    public function equals(Object $obj)
    {
        if($obj() == $this())
        {
            return true;
        }

        return false;
    }
}
