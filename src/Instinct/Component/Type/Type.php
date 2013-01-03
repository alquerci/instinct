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

use Instinct\Component\GarbageCollector\GC;

/**
 * Extend it to enforce strong typing.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Type extends Object
{
    /**
     * @var integer
     */
    protected $_gcAddress = -1;

    /**
     * Set the default value.
     *
     * @since v0.1
     */
    abstract protected function setDefault();

    /**
     * Returns a php native representation
     *
     * @since v0.1
     *
     * @return mixed
     */
    abstract public function getValue();

    /**
     * Use strong typing to ensure a certain type.
     *
     * Declares a new pointer and assign it year object.
     *
     * @since v0.1
     *
     * @param &NULL $ptr
     * @param mixed $initial_value [Optional]
     * @throws \LogicException
    */
    final static public function pnew(&$ptr, $initial_value = NULL)
    {
        if ($ptr !== null)
        {
            $message = "Trying to redefine a pointer.";
            throw new \LogicException($message, E_PARSE);
        }

        $ptr = new static($initial_value);
        $ptr->_gcAddress = GC::malloc($ptr);
    }

    /**
     * @since v0.1
     *
     * @param mixed $initial_value
     * @throws \UnexpectedValueException
     */
    final private function __construct($initial_value)
    {
        $this->setDefault();

        if ($initial_value !== null)
        {
            if ($this->setValue($initial_value) === false)
            {
                $type = gettype($initial_value);
                $callClass = get_called_class();
                $mess = "$type could not be converted to $callClass.";

                throw new \UnexpectedValueException($mess);
            }
        }
    }

    /**
     * @since v0.1
     */
    final public function __destruct()
    {
        $ptr = &GC::getRef($this->_gcAddress);

        if ($ptr === $this || $ptr === null) // Garbage Collector.
        {
            // Removing the obsolete pointer.
            GC::free($this->_gcAddress);
        }
        else
        {
            if ($ptr instanceof $this)
            {
                $ptr = clone $ptr;
            }
            else
            {
                try
                {
                    if (is_object($ptr))
                    {
                        $ptr = clone $ptr;
                    }

                    $ptr = new static($ptr);
                }
                catch (\Exception $e)
                {
                    // Nothing changed.
                    $ptr = clone $this;
                }
            }

            // Relocate the pointer.
            $ptr->_gcAddress = GC::malloc($ptr);

            // Removing the obsolete pointer.
            GC::free($this->_gcAddress);
        }
    }

    /**
     * @since v0.1
     *
     */
    public function __invoke()
    {
        return $this->getValue();
    }

    /**
     * @since v0.1
     *
     * @param string $value
     * @return boolean
     */
    protected function fromString($value)
    {
        return false;
    }

    /**
     * @since v0.1
     *
     * @param object $value
     * @return boolean
     */
    protected function fromObject($value)
    {
        return false;
    }

    /**
     * @since v0.1
     *
     * @param boolean $value
     * @return boolean
     */
    protected function fromBool($value)
    {
        return false;
    }



    /**
     * @since v0.1
     *
     * @param integer $value
     * @return boolean
     */
    protected function fromInt($value)
    {
        return false;
    }

    /**
     * @since v0.1
     *
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value)
    {
        return false;
    }

    /**
     * @param array $value
     * @return boolean
     */
    protected function fromArray($value)
    {
        return false;
    }

    /**
     * @param resource $value
     * @return boolean
     */
    protected function fromResource($value)
    {
        return false;
    }

    /**
     * @since v0.1
     *
     * @param mixed $value
     * @return boolean
     */
    private function setValue($value)
    {
        if(is_object($value))
        {
            return $this->fromObject($value);
        }
        elseif (is_bool($value))
        {
            return $this->fromBool($value);
        }
        elseif (is_int($value))
        {
            return $this->fromInt($value);
        }
        elseif (is_double($value))
        {
            return $this->fromDouble($value);
        }
        elseif (is_string($value))
        {
            return $this->fromString($value);
        }
        elseif (is_array($value))
        {
            return $this->fromArray($value);
        }
        elseif (is_resource($value))
        {
            return $this->fromResource($value);
        }

        return false;
    }


}

