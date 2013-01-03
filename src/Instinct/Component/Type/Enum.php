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
 * It used to enforce strong typing of the enum type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Enum extends Scalar
{
    /**
     * @var string
     */
    protected $rawData;

    /**
     * @var array
     */
    static private $_validClass = array();

    /**
     * @since v0.1
     *
     * @param string $method
     * @param array $args
     * @throws \BadMethodCallException
     * @return Enum
     */
    static public function __callStatic($method, $args)
    {
        $constList = static::getConstList();
        if (array_key_exists($method, $constList))
        {
            static::pnew($ptr);
            $ptr = $constList[$method];
            return $ptr;
        }

        throw new \BadMethodCallException();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::getValue()
     *
     * @retyurn string
     */
    public function getValue()
    {
        return $this->toString();
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::setDefault()
     *
     */
    protected function setDefault()
    {
        $constList = static::getConstList();
        $this->rawData = array_shift($constList);
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromBool()
     *
     * @param unknown_type $value
     */
    protected function fromBool($value)
    {
        return $this->setMe($value);
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromInt()
     *
     * @param unknown_type $value
     */
    protected function fromInt($value)
    {
        return $this->setMe($value);
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromDouble()
     *
     * @param unknown_type $value
     */
    protected function fromDouble($value)
    {
        return $this->setMe($value);
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromString()
     *
     * @param unknown_type $value
     */
    protected function fromString($value)
    {
        return $this->setMe($value);
    }

    /**
     * @since v0.1
     *
     * @throws \LogicException
     * @return string[]
     */
    static public function getConstList(){
        $callClass = get_called_class();
        $refClass = new \ReflectionClass($callClass);
        $constList = $refClass->getConstants();

        if(in_array($callClass, self::$_validClass))
        {
            return $constList;
        }

        self::$_validClass[] = $callClass;

        foreach ($constList as $const)
        {
            if (!is_string($const))
            {
                $callClass = get_called_class();
                $message =
                "All constants of Class ".$callClass." must be strings. "
                    . "For use it into a switch and more.";

                throw new \LogicException($message, E_PARSE);
            }
        }

        return $constList;
    }

    /**
     * @since v0.1
     *
     * @param mixed $value
     * @return boolean
     */
    private function setMe($value)
    {
        $consts = static::getConstList();
        $index = array_search($value, $consts);
        if ( $index !== false )
        {
            $this->rawData = $consts[$index];
            return true;
        }
        else
        {
            return false;
        }
    }
}