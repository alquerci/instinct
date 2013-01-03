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

namespace Instinct\Component\GarbageCollector;

/**
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class GC
{
    /**
     * @var int
     */
    static private $_bufferSize = 10000;

    static private $_size = 0;

    /**
     * @var array
     */
    static private $_memory = array();

    /**
     * Store $value and return memory address
     *
     * @since v0.1
     *
     * @param mixed $value
     * @return number
     */
    static public function malloc(&$value)
    {
        $address = -1;

        do
        {
            $address++;
        }
        while(self::isFree($address) === false);

        self::$_memory[$address] = &$value;
        self::$_size++;
        if(self::$_size > self::$_bufferSize)
        {
            self::collect();
        }

        return $address;
    }

    /**
     * @since v0.1
     *
     * @param integer $address
     * @return multitype:
     */
    static public function &getRef($address)
    {
        return self::$_memory[$address];
    }

    static public function free($address)
    {
        unset(self::$_memory[$address]);
        self::$_size--;
    }

    /**
     * Forces collection of any existing garbage cycles
     *
     * @since v0.1
     *
     */
    static public function collect()
    {
        $keys = array_keys(self::$_memory);
        reset($keys);
        while (list(,$address) = each($keys))
        {
            if (array_key_exists($address, self::$_memory))
            {
                if(self::_refCount(self::$_memory[$address]) === 0)
                {
                    // destruction of the object
                    self::free($address);
                }
            }
        }
    }

    /**
     * @since v0.1
     *
     * @param integer $address
     * @return boolean
     */
    static private function isFree($address)
    {
        if(array_key_exists($address, self::$_memory) === false)
        {
            return true;
        }

        if(self::$_memory[$address] === null)
        {
            return true;
        }

        return false;
    }

    /**
     * <p>Return the reference count of a variable.
     * Returns 0 if a variable has no reference other than itself
     * or doesn't exist.</p>
     *
     * @since v0.1
     * @link http://www.php.net/manual/fr/function.debug-zval-dump.php#109146
     *
     * @param mixed $var
     * @param boolean $details
     * @return number
     */
    static private function _refCount(&$var)
    {
        ob_start();
        debug_zval_dump(array(&$var));

        $sub = substr(ob_get_clean(), 24);
        $pattern = "/^.+?refcount\((\d+)\).+$/ms";
        $nbref = preg_replace($pattern, '$1', $sub, 1);
        return $nbref - 4;
    }
}