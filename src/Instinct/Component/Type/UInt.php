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
 * It used to enforce strong typing of the unsigned integer type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
class UInt extends Int
{
    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Int::fromInt()
     *
     * @param int $value
     * @return boolean
     */
    protected function fromInt($value)
    {
        if ($value < 0)
        {
            $value = 0;
        }

        $this->_rawData = $value;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Int::fromBool()
     *
     * @param bool $value
     * @return boolean
     */
    protected function fromBool($value)
    {
        if ($value < 0)
        {
            $value = 0;
        }
        $this->_rawData = (integer) $value;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Int::fromDouble()
     *
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value)
    {
        if ($value < 0)
        {
            $value = 0;
        }
        $this->_rawData = (integer) $value;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Int::fromString()
     *
     * @param string $value
     * @return boolean
     */
    protected function fromString($value)
    {
        $value = (integer) $value;
        if ($value < 0)
        {
            $value = 0;
        }
        $this->_rawData = $value;
        return true;
    }
}