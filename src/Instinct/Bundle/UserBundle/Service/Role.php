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
 * @copyright Copyright (C) 2012  alexandre.quercia
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @author alexandre.quercia
 */

namespace Instinct\Bundle\UserBundle\Service;

use Instinct\Bundle\UserBundle\Entity\User;

use Symfony\Component\Security\Core\Role\Role as BaseRole;

use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

/**
 * @author alexandre.quercia
 * @since v0.0.3
 */
class Role
{
    /**
     * @var RoleHierarchyInterface
     */
    private $roleHierarchy;

    /**
     * @since v0.0.3
     *
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * Return all register roles.
     *
     * @since v0.0.3
     *
     * @return Role[]
     */
    public function getRoles()
    {
        $roleRoot = new BaseRole(User::ROLE_SUPER_ADMIN);
        $roles = $this->roleHierarchy->getReachableRoles(array($roleRoot));

        return $roles;
    }
}