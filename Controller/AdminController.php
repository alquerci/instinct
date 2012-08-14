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


use Symfony\Component\Form\FormConfigInterface;

use FOS\UserBundle\Form\Handler\ProfileFormHandler;

use Instinct\Bundle\UserBundle\Form\UserType;

use Instinct\Bundle\UserBundle\Entity\User;

use FOS\UserBundle\Doctrine\UserManager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class AdminController extends Controller
{
    /**
     * TODO Implement pagination.
     *
     * @since v0.0.2-dev
     *
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        $route = 'instinct_user_admin_user_index';
        $param = array(
            "page" => $page
            );
        $url = $this->generateUrl($route, $param);
        return $this->redirect($url);
    }


    /**
     * @since v0.0.2-dev
     *
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->setFlash($action, $value);
    }

    /**
     * @since v0.0.2-dev
     *
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }

    /**
     * @since v0.0.2-dev
     *
     * @return ProfileFormHandler
     */
    protected function getProfileFormHandler()
    {
        return $this->get('fos_user.profile.form.handler');
    }
}