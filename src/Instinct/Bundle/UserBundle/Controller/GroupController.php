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

namespace Instinct\Bundle\UserBundle\Controller;

use Symfony\Component\Form\Form;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Instinct\Bundle\UserBundle\Entity\Group;
use Instinct\Bundle\UserBundle\Form\GroupType;

/**
 * Group controller.
 *
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class GroupController extends Controller
{
    /**
     * Lists all Group entities.
     *
     * @since v0.0.2-dev
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $groups = $this->get('fos_user.group_manager')->findGroups();

        return $this->render('InstinctUserBundle:Group:index.html.twig',
            array(
                'groups' => $groups,
                )
            );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @since v0.0.2-dev
     *
     * @param Group $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Group $id)
    {
        $deleteForm = $this->createDeleteForm($id->getId());

        return $this->render('InstinctUserBundle:Group:show.html.twig',
            array(
                'group'      => $id,
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @since v0.0.2-dev
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Group();
        $type   = new GroupType($this->container);
        $form   = $this->createForm($type, $entity);

        return $this->render('InstinctUserBundle:Group:new.html.twig',
            array(
                'group' => $entity,
                'form'   => $form->createView(),
                )
            );
    }

    /**
     * Creates a new Group entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Group();
        $type   = new GroupType($this->container);
        $form   = $this->createForm($type, $entity);

        $form->bind($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->setFlash('fos_user_success', 'group.flash.created');

            return $this->redirect(
                $this->generateUrl('instinct_user_admin_group_show',
                array(
                    'id' => $entity->getId()
                    )
                )
            );
        }

        return $this->render('InstinctUserBundle:Group:new.html.twig', array(
            'group' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @since v0.0.2-dev
     *
     * @param Group $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Group $id)
    {
        $type       = new GroupType($this->container);
        $editForm   = $this->createForm($type, $id);
        $deleteForm = $this->createDeleteForm($id->getId());

        return $this->render('InstinctUserBundle:Group:edit.html.twig',
            array(
                'group'      => $id,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Edits an existing Group entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @param Group $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Group $id)
    {
        $type       = new GroupType($this->container);
        $editForm   = $this->createForm($type, $id);
        $deleteForm = $this->createDeleteForm($id->getId());

        $editForm->bind($request);

        if ($editForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            $this->setFlash('fos_user_success', 'group.flash.updated');

            return $this->redirect(
                $this->generateUrl('instinct_user_admin_group_edit',
                array(
                    'id' => $id->getId()
                    )
                )
            );
        }

        return $this->render('InstinctUserBundle:Group:edit.html.twig',
            array(
                'entity'      => $id,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Deletes a Group entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @param Group $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Group $id)
    {
        $form = $this->createDeleteForm($id->getId());
        $form->bind($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $this->setFlash('fos_user_success', 'group.flash.deleted');

            $em->remove($id);
            $em->flush();
        }

        return $this->redirect(
            $this->generateUrl('instinct_user_admin_group_index')
            );
    }

    /**
     * @since v0.0.2-dev
     *
     * @param integer $id <p>Group id</p>
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
     * @since v0.0.2-dev
     *
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->setFlash($action, $value);
    }
}
