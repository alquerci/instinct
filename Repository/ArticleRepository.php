<?php
/**
 * ProgramName - Program in PHP
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
 * @copyright Copyright (C) 2012  alexandre.quercia
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
 * @author alexandre.quercia
 */


namespace Instinct\Bundle\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
 * @author alexandre.quercia
 * @since 1.0
 * @version 0.1
 *
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Retourne le nombre total d'articles.
     *
     * @license http://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
     * @author alexandre.quercia
     * @since 1.0
     * @version 0.1
     *
     * @return number
     */
    public function getCount()
    {
        $query = $this->createQueryBuilder("a")->select("COUNT(a)");

        return (int) $query->getQuery()->getSingleScalarResult();
    }
}