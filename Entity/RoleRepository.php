<?php
/**
 * Instinct - Application PHP using Symfony Framework
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
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @author alexandre.quercia
 */

namespace Instinct\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\EntityRepository;

/**
 * RoleRepository
 *
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class RoleRepository extends EntityRepository
{
    /**
     * @since v0.0.2-dev
     *
     * @param array $array
     * @return string|\Doctrine\Common\Collections\ArrayCollection
     *     <p>Array for \Instinct\Bundle\UserBundle\Entity\Role
     *     or string if an role does not exist</p>
     */
    public function findByArray(array $array)
    {
        $roleCollection = new ArrayCollection();
        foreach ($array as $role)
        {
            $role = $this->findOneBy(array('name' => $role));
            if (null === $role)
            {
                return $role;
            }
            $roleCollection->add($role);
        }

        return $roleCollection;
    }

    /**
     * Get all role.
     *
     * @since v0.0.2-dev
     * @see \Doctrine\ORM\EntityRepository::findAll()
     *
     * @return Role[]
     * <p>Return an array of Role with the rolename on index.</p>
     */
    public function findAll()
    {
        $roles = array();

        $array = parent::findAll();

        foreach ($array as $role)
        {
            $roles["$role"] = $role;
        }

        return $roles;
    }
}
