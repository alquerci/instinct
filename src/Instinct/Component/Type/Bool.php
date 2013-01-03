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
 * It used to enforce strong typing of the bool type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
class Bool extends Enum
{
    const FALSE = "";
    const TRUE = "1";

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Scalar::toBoolean()
     *
     * @return boolean
     */
    public function toBoolean()
    {
        if ($this->rawData === self::TRUE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Enum::getValue()
     *
     */
    public function getValue()
    {
        return $this->toBoolean();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Scalar::toArray()
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this->toBoolean();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Scalar::toDouble()
     *
     * @return number
     */
    public function toDouble()
    {
        return (double) $this->toBoolean();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Scalar::toInteger()
     *
     * @return number
     */
    public function toInteger()
    {
        return (integer) $this->toBoolean();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Scalar::toString()
     *
     * @return string
     */
    public function toString()
    {
        return (string) $this->toBoolean();
    }


    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Enum::fromBool()
     *
     * @param boolean $value
     * @return boolean
     */
    protected function fromBool($value)
    {
        if ($value === true)
        {
            $this->rawData = static::TRUE;
        }
        else
        {
            $this->rawData = static::FALSE;
        }
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Enum::fromInt()
     *
     * @param int $value
     * @return boolean
     */
    protected function fromInt($value)
    {
        if ($value == 0)
        {
            $this->rawData = static::FALSE;
        }
        else
        {
            $this->rawData = static::TRUE;
        }
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromArray()
     *
     * @param array $value
     * @return boolean
     */
    protected function fromArray($value)
    {
        if (count($value) == 0)
        {
            $this->rawData = static::FALSE;
        }
        else
        {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Enum::fromDouble()
     *
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value)
    {
        if ($value == 0.0)
        {
            $this->rawData = static::FALSE;
        }
        else
        {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Enum::fromString()
     *
     * @param string $value
     * @return boolean
     */
    protected function fromString($value)
    {
        if ($value == "" or $value == "0")
        {
            $this->rawData = static::FALSE;
        }
        else
        {
            $this->rawData = static::TRUE;
        }

        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromObject()
     *
     * @param object $value
     * @return boolean
     */
    protected function fromObject($value)
    {
        $this->rawData = static::TRUE;

        if ($value instanceof \SimpleXMLElement)
        {
            $simpleXML = (bool) $value;
            if ($simpleXML)
            {
                $this->rawData = static::TRUE;
            }
            else
            {
                $this->rawData = static::FALSE;
            }
        }
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromResource()
     *
     * @param resource $value
     * @return boolean
     */
    protected function fromResource($value)
    {
        $this->rawData = static::TRUE;
        return true;
    }

}