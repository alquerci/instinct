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

use Symfony\Component\Form\Form;

use Symfony\Component\Form\FormBuilder;

use FOS\UserBundle\Doctrine\UserManager;

use FOS\UserBundle\Form\Handler\ProfileFormHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Instinct\Bundle\UserBundle\Entity\User;
use Instinct\Bundle\UserBundle\Form\UserType;

/**
 * AdminUser controller.
 *
 * @author alexandre.quercia
 * @since v0.0.3
 */
class AdminUserController extends Controller
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
        $users = $this->getUserManager()->findUsers();

        // Render
        $view = 'InstinctUserBundle:AdminUser:index.html.twig';
        $parameters = array(
            'users' => $users,
            );
        return $this->render($view, $parameters);
    }

    /**
     * Finds and displays a User entity.
     *
     * @since v0.0.3
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user->getId());

        // Render
        $view = 'InstinctUserBundle:AdminUser:show.html.twig';
        $parameters = array(
            'user'        => $user,
            'delete_form' => $deleteForm->createView(),
            );
        return $this->render($view, $parameters);
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @since v0.0.3
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $user = new User();
        $em   = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserType($em), $user);

        // Render
        $view = 'InstinctUserBundle:AdminUser:new.html.twig';
        $parameters = array(
            'user'   => $user,
            'form'   => $form->createView(),
            );
        return $this->render($view, $parameters);
    }

    /**
     * Creates a new User entity.
     *
     * @since v0.0.3
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $user  = new User();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserType($em), $user);
        $form->bind($request);

        if ($form->isValid())
        {
            $em->persist($user);
            $em->flush();

            $route = 'instinct_user_admin_user_show';
            $param = array(
                'user' => $user->getId()
                );
            $url = $this->generateUrl($route, $param);
            return $this->redirect($url);
        }

        // Render
        $view = 'InstinctUserBundle:AdminUser:new.html.twig';
        $parameters = array(
            'user'   => $user,
            'form'   => $form->createView(),
            );
        return $this->render($view, $parameters);
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @since v0.0.3
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(User $user)
    {
        if ($this->getUser() === $user)
        {
            $url = $this->generateUrl("instinct_user_admin_user_index");
            $this->setFlash("instinct_user_edit", "You can't edit your own profile");
            return $this->redirect($url);
        }

        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm(new UserType($em), $user);
        $deleteForm = $this->createDeleteForm($user->getId());

        // Render
        $view = 'InstinctUserBundle:AdminUser:edit.html.twig';
        $parameters = array(
            'user'        => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        return $this->render($view, $parameters);
    }

    /**
     * Edits an existing User entity.
     *
     * @since v0.0.3
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm(new UserType($em), $user);
        $deleteForm = $this->createDeleteForm($user->getId());

        $editForm->bind($request);

        if ($editForm->isValid())
        {
            $this->getUserManager()->updateUser($user);

            $this->setFlash('fos_user_success', 'profile.flash.updated');

            $route = 'instinct_user_admin_user_edit';
            $param = array(
                'user' => $user->getId(),
            );
            $url = $this->generateUrl($route, $param);
            return $this->redirect($url);
        }
        else
        {
            $this->setFlash('fos_user_success', 'Unable to update the user.');
            throw new Controller();
        }

        // Render
        $view = 'InstinctUserBundle:AdminUser:edit.html.twig';
        $parameters = array(
            'user'   => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        return $this->render($view, $parameters);
    }

    /**
     * Deletes a User entity.
     *
     * @since v0.0.3
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user->getId());
        $form->bind($request);

        if ($form->isValid())
        {
            $this->getUserManager()->deleteUser($user);
        }

        $route = 'instinct_user_admin_user_index';
        $param = array(
        );
        $url = $this->generateUrl($route, $param);
        return $this->redirect($url);
    }

    /**
     * @since v0.0.3
     *
     * @param integer $id
     * @return Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * @since v0.0.3
     *
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->setFlash($action, $value);
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

    /**
     * @since v0.0.3
     *
     * @return ProfileFormHandler
     */
    protected function getProfileFormHandler()
    {
        return $this->get('fos_user.profile.form.handler');
    }
}
