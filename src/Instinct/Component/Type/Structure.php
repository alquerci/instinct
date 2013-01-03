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
 * It used to enforce strong typing of the structure type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Structure extends Composite
{
    static private $_validClass = array();

    /**
     * Declare all properties:
     *
     * - Type::pnew($this->property1)
     * - Type::pnew($this->property2)
     * - ...
     *
     * @since v0.1
     *
     */
    abstract protected function build();


    /**
     * Returns an associative array with the name of the index properties.
     * Case sensitive.
     *
     * @since v0.1
     *
     * @return array
    */
    public function toArray()
    {
        $array = array();

        $static = new \ReflectionClass(get_called_class());
        $properties = $static->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach($properties as $property)
        {
            $name = $property->getName();
            $array[$name] = $this->$name->getValue();
        }

        return $array;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::setDefault()
     *
     * @throws \LogicException
     */
    protected function setDefault()
    {
        $callClass = get_called_class();
        $this->build();

        if(in_array($callClass, self::$_validClass))
        {
            return;
        }

        // verification that all the property are instances of Type
        $static = new \ReflectionClass(get_called_class());
        $properties = $static->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property)
        {
            $name = $property->getName();
            if (! $this->$name instanceof Type)
            {
                $message = ""
                . get_called_class()."->".$name." "
                . "property must point to an instance of "
                . __NAMESPACE__ . "\\Type."
                ;

                throw new \LogicException($message, E_PARSE);
            }
        }

        self::$_validClass[] = $callClass;
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
        try
        {
            foreach ($value as $name => $property)
            {
                if (property_exists($this, $name))
                {
                    $this->$name = $property;
                }
            }
        }
        catch (\Exception $e)
        {
            return false;
        }

        return true;
    }

}
