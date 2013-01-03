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
 * It used to enforce strong typing of the array type.
 *
 * @author alexandre.quercia
 * @since v0.1
 */
class Storage extends Composite
implements \SeekableIterator, \RecursiveIterator, \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    private $_array;

    /**
     * @var int
     */
    private $_size = 0;

    // Methods for the interface Iterator \\

    /**
     * Returns the key of the current element.
     *
     * @since v0.1
     * @see SeekableIterator::key()
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->_array);
    }

    /**
     * Returns the current element.
     *
     * @since v0.1
     * @see SeekableIterator::current()
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->_array);
    }

    /**
     * Moves to the next item.
     *
     * @since v0.1
     * @see SeekableIterator::next()
     *
     */
    public function next()
    {
        do
        {
            $v = next($this->_array);
        }
        while ($v === null);
    }

    /**
     * Rewind the internal array pointer.
     *
     * @since v0.1
     *
     */
    public function prev()
    {
        do
        {
            $v = prev($this->_array);
        }
        while ($v === null);
    }

    /**
     * Checks whether the current position is valid.
     *
     * @since v0.1
     * @see SeekableIterator::valid()
     *
     * @return boolean
     */
    public function valid()
    {
        if ($this->key() === null)
        {
            return false;
        }
        return true;
    }

    /**
     * Replace the iterator to the first element.
     *
     * @since v0.1
     * @see SeekableIterator::rewind()
     *
     */
    public function rewind()
    {
        $v = reset($this->_array);
        if ($v === null)
        {
            $this->next();
        }
    }

    // Methodes pour l'interface ArrayAccess \\
    /**
     * Indicates whether the index exists.
     *
     * @since v0.1
     * @see ArrayAccess::offsetExists()
     *
     * @param mixed $index
     * @return boolean
     */
    public function offsetExists($index)
    {
        if (is_object($index))
        {
            if (method_exists($index, "__toString"))
            {
                $index = $index->__toString();
            }
            else
            {
                $index = spl_object_hash($index);
            }
        }

        return array_key_exists($index, $this->_array);
    }

    /**
     * Returns the value at the given index.
     *
     * @since v0.1
     * @see ArrayAccess::offsetGet()
     *
     * @param mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {
        if (is_object($index))
        {
            if (method_exists($index, "__toString"))
            {
                $index = $index->__toString();
            }
            else
            {
                $index = spl_object_hash($index);
            }
        }

        if($this->offsetExists($index) !== false)
        {
            return $this->_array[$index];
        }

        return null;
    }

    /**
     * Assign a value to the given index.
     *
     * @since v0.1
     * @see ArrayAccess::offsetSet()
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetSet($index, $value)
    {
        if ($index === null)
        {
            if ($value !== null)
            {
                $this->_size++;
            }
            $this->_array[] = $value;
        }
        else
        {
            if (is_object($index))
            {
                if (method_exists($index, "__toString"))
                {
                    $index = $index->__toString();
                }
                else
                {
                    $index = spl_object_hash($index);
                }
            }

            if($this->offsetExists($index) !== false)
            {
                $this->_array[$index] = $value;
            }
            else
            {
                $this->_size++;
                $this->_array[$index] = $value;
            }
        }
    }

    /**
     * Destroyed the element at index $index.
     *
     * @since v0.1
     * @see ArrayAccess::offsetUnset()
     *
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        if (is_object($index))
        {
            if (method_exists($index, "__toString"))
            {
                $index = $index->__toString();
            }
            else
            {
                $index = spl_object_hash($index);
            }
        }

        if($this->offsetExists($index) !== false)
        {
            $this->_size--;
            $this->_array[$index] = null;
        }
    }

    // Methodes pour l'interface Countable \\

    /**
     * Counts the number of array elements.
     *
     * @since v0.1
     * @see Countable::count()
     *
     * @return int
     */
    public function count()
    {
        return $this->_size;
    }

    // Methodes pour l'interface SeekableIterator \\

    /**
     * Seeks to a position
     *
     * @since v0.1
     * @see SeekableIterator::seek()
     *
     * @param int $position
     * @throws \OutOfBoundsException
     */
    public function seek($position)
    {
        if (is_object($position))
        {
            if (method_exists($position, "__toString"))
            {
                $position = (int) $position->__toString();
            }
            else
            {
                throw new \OutOfBoundsException();
            }
        }

        $position = (int) $position;

        if($position < $this->_size)
        {
            $this->rewind();
            for ($i=0 ; $i < $position ; $i++)
            {
                $this->next();
            }
        }
        else
        {
            throw new \OutOfBoundsException();
        }
    }

    // Methodes pour l'interface RecursiveIterator \\

    /**
     * Checks whether the value of the current index is
     * an object \ Traversable or array.
     *
     * @since v0.1
     * @see RecursiveIterator::hasChildren()
     *
     * @return boolean
     */
    public function hasChildren(){
        $child = $this->current();

        if($child instanceof \RecursiveIterator){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Returns an RecursiveIterator for the current entry.
     *
     * @since v0.1
     * @see RecursiveIterator::getChildren()
     *
     * @throws \LogicException
     * <p>The current entry does not contain a RecursiveIterator</p>
     * @return \RecursiveIterator
     */
    public function getChildren()
    {
        $child = $this->current();

        if($child instanceof \RecursiveIterator){
            return $child;
        }else{
            throw new \LogicException(
                "The current entry does not contain a RecursiveIterator");
        }
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Composite::toArray()
     *
     * @return array
     */
    public function toArray()
    {
        return iterator_to_array($this, true);
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::setDefault()
     *
     */
    protected function setDefault()
    {
        $this->_array = array();
        $this->_size = 0;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromString()
     *
     * @param string $value
     * @return boolean
     */
    protected function fromString($value)
    {
        $this->_array = (array) $value;
        $this->_size = 1;
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
        $this->_array = (array) $value;
        $this->_size = 1;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromInt()
     *
     * @param int $value
     * @return boolean
     */
    protected function fromInt($value)
    {
        $this->_array = (array) $value;
        $this->_size = 1;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromDouble()
     *
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value)
    {
        $this->_array = (array) $value;
        $this->_size = 1;
        return true;
    }

    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Type::fromBool()
     *
     * @param bool $value
     * @return boolean
     */
    protected function fromBool($value)
    {
        $this->_array = (array) $value;
        $this->_size = 1;
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
        $this->_size = count($value);
        $this->_array = $value;
        return true;
    }


    /**
     * @since v0.1
     * @see \Instinct\Component\Type\Composite::fromObject()
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
            $this->_array = array($value);
            $this->_size = 1;
            return true;
        }

        return true;
    }
}
