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
interface ComparableInterface
{
    /**
     * <p>Compares the current instance with another object of the
     * same type and returns an integer that indicates whether
     * the current instance precedes, follows, or occurs in
     * the same position in the sort order as the other object.</p>
     *
     * @since v0.1
     *
     * @param Object $obj
     *
     * @throws \InvalidArgumentException
     * obj is not the same type as this instance.
     *
     * @return int  <p>- Less than zero,
     * this instance is less than obj. <br />
     * - Zero, this instance is equal to obj.  <br />
     * - Greater than zero,
     * This instance is greater than obj. </p>
     */
    public function compareTo(Object $obj);

}