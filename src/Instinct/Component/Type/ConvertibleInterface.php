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
 * <p>Defines methods for converting an object into a php native type.</p>
 *
 * @author alexandre.quercia
 * @since v0.1
 */
interface ConvertibleInterface
{

    /**
     * @since v0.1
     *
     * @return boolean
     */
    public function toBoolean();

    /**
     * @since v0.1
     *
     * @throws \RangeException <p>If the value is outside the domain
     * PHP_INT_MAX and ~PHP_INT_MAX</p>
     * @return integer
    */
    public function toInteger();

    /**
     * @since v0.1
     *
     * @throws \RangeException <p>If the converted value worth (-)INF</p>
     * @return double
    */
    public function toDouble();

    /**
     * @since v0.1
     *
     * @return string
     */
    public function toString();

    /**
     * @since v0.1
     *
     * @return array
     */
    public function toArray();
}