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
 * You can use the PHPdoc tag property-read to declared your properties
 * <pre>@property-read type $name [description]</pre>
 *
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class Object
{
    static private $_NO_EMPTY_STRING = 'Expected not empty string.';

    /**
     * @var array
     */
    private $_getters = array();

    public function __destruct()
    {
    }

    /**
     * Hydrate the object pass an associative array as an argument.
     * This table must have the name of the index in propriétées.
     *
     * @since v0.1
     *
     * @param array $datas
     */
    private function _hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            // It retrieves the name of the setter for the attribute
            $method = $this->_formatSetter($key);

            // If the corresponding setter exists
            if (method_exists($this, $method))
            {
                // Called setter
                $this->$method($value);
            }
        }
    }

    /**
     * Convert the name of a property in a name index table.
     * With following steps:
     * - Deleting a "_" if it exists.
     * - Transformation of the first character capitalized.
     * - Adding "set" at the beginning.
     *
     * @since v0.1
     *
     * @param string $key
     * @return string
     */
    private function _formatSetter($key)
    {
        if(substr($key, 0, 1) == "_"){
            $key = substr($key, 1);
        }
        return 'set'.ucfirst($key);
    }

    /**
     * Add readable property
     *
     * @since v0.1
     *
     * @param string $varName
     * @throws \InvalidArgumentException
     */
    protected function _addGetter($varName)
    {
        if (!is_string($varName) || empty($varName))
        {
            throw new \InvalidArgumentException(self::$_NO_EMPTY_STRING);
        }

        if(!property_exists($this, $varName))
        {
            throw new \InvalidArgumentException("Property $varName does not exist.");
        }

        $this->_getters[$varName] = $varName;
    }


    /**
     * Remove readable property
     *
     * @since v0.1
     *
     * @param string $varName
     * @throws \InvalidArgumentException
     * @return boolean
     */
    protected function _delGetter($varName)
    {
        if (!is_string($varName) || empty($varName))
        {
            throw new \InvalidArgumentException(self::$_NO_EMPTY_STRING);
        }

        if(isset($this->_getters[$varName]))
        {
            unset($this->_getters[$varName]);
        }

        return true;
    }

    /**
     * Remove all readable properties
     *
     * @since v0.1
     *
     * @return boolean
     */
    protected function _delAllGetters()
    {
        $this->_getters = array();

        return true;
    }

    /**
     * @since v0.1
     *
     * @param string $var
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($var)
    {
        if ($this->__isset($var))
        {
            $refProperty = new \ReflectionProperty(get_called_class(), $var);
            $refProperty->setAccessible(true);
            $value = $refProperty->getValue($this);
            $refProperty->setAccessible(false);

            return $value;
        }
        throw new \InvalidArgumentException("Property ".get_called_class()."->".$var." not available");
    }

    /**
     * @since v0.1
     *
     * @param string $varName
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __set($varName, $value)
    {
        if (!is_string($varName) || empty($varName))
        {
            throw new \InvalidArgumentException(self::$_NO_EMPTY_STRING);
        }
        throw new \RuntimeException("Property " . get_called_class() . "->".$varName." is not writable.");
    }

    /**
     * @since v0.1
     *
     * @param string $var
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public function __isset($var){
        if (!is_string($var) || empty($var))
        {
            throw new \InvalidArgumentException(self::$_NO_EMPTY_STRING);
        }


        if (array_key_exists($var, $this->_getters))
        {
            return true;
        }
        return false;
    }


    /**
     * @since v0.1
     *
     * @param string $methodName
     * @param array $args
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException
     */
    public function __call($methodName, $args)
    {
        if (!is_string($methodName) || empty($methodName))
        {
            throw new \InvalidArgumentException(self::$_NO_EMPTY_STRING);
        }
        if($this->__isset($methodName))
        {
            trigger_error("The parenthesis are not used to access the properties read only", E_USER_DEPRECATED);
            return $this->__get($methodName);
        }
        $str_args = "";
        foreach ($args as $arg)
        {
            $str_args .= gettype($arg).", ";
        }

        $str_args = substr($str_args, 0, strlen($str_args)-2);

        throw new \BadMethodCallException("Call un undefined methode " . gettype($this) . "->" . $methodName . "($str_args)");
    }



    /**
     * Returns the name of the class in "Late Static Binding"
     * without the namespace.
     *
     * @since v0.1
     *
     * @return string
     */
    static protected function getClassName()
    {
        $classPart = preg_split("#[\\\]#", get_called_class());
        $name = array_pop($classPart);

        return $name;
    }

    /**
     * <p>This function returns a unique identifier of this object.
     * This id can be used as a hash key for storing objects
     * or for identifying an object.</p>
     *
     * @since v0.1
     * @link http://www.php.net/manual/en/function.spl-object-hash.php
     * @see spl_object_hash()
     *
     * @return string
     */
    final public function getHashCode()
    {
        return spl_object_hash($this);
    }

    /**
     * @since v0.1
     *
     * @param Object $obj
     * @return boolean
     */
    public function equals(Object $obj)
    {
        if($obj->getHashCode() === $this->getHashCode())
        {
            return true;
        }

        return false;
    }
}