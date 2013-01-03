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
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Composite extends Type
{
    /**
     * @since v0.1
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class();
    }

    /**
     * @since v0.1
     *
     */
    final public function __clone()
    {
        $array = $this->toArray();
        $this->setDefault();
        $clone = array();

        foreach ($array as $key => $value)
        {
            if(is_object($value))
            {
                $clone[$key] = clone $value;
            }
            else
            {
                $clone[$key] = $value;
            }
        }

        $this->fromArray($clone);
    }

    /**
     * @since v0.1
     *
     * @return array
     */
    abstract public function toArray();

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromObject()
     *
     * @param object $value
     * @return boolean
     */
    protected function fromObject($value)
    {
        if ($value instanceof \Traversable)
        {
            $array = array();
            $array = iterator_to_array($value, true);

            return $this->fromArray($array);
        }
        else
        {
            return false;
        }

        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::getValue()
     *
     * return array
     */
    final public function getValue()
    {
        return $this->toArray();
    }

}
