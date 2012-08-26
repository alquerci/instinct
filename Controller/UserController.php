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

namespace Instinct\Bundle\UserBundle\Controller;


use FOS\UserBundle\Doctrine\UserManager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Instinct\Bundle\UserBundle\Entity\User;

/**
 * User controller.
 *
 * @author alexandre.quercia
 * @since v0.0.3
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @since v0.0.3
     *
     * @param integer $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        $entities = $this->getUserManager()->findUsers();

        return $this->render('InstinctUserBundle:User:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @since v0.0.3
     *
     * @param string $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($username)
    {
        $entity = $this->getUserManager()->findUserByUsername($username);

        return $this->render('InstinctUserBundle:User:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * @since v0.0.3
     *
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }
}
