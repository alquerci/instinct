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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Instinct\Bundle\UserBundle\Entity\Role;
use Instinct\Bundle\UserBundle\Form\RoleType;

/**
 * Role controller.
 *
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class RoleController extends Controller
{
    /**
     * Lists all Role entities.
     * TODO Implement pagination.
     *
     * @since v0.0.2-dev
     *
     * @param interger $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InstinctUserBundle:Role')->findAll();

        return $this->render('InstinctUserBundle:Role:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Finds and displays a Role entity.
     *
     * @since v0.0.2-dev
     *
     * @param Role $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Role $id)
    {
        $deleteForm = $this->createDeleteForm($id->getId());

        return $this->render('InstinctUserBundle:Role:show.html.twig',
            array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Displays a form to create a new Role entity.
     *
     * @since v0.0.2-dev
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = new Role();
        $type   = new RoleType($em);
        $form   = $this->createForm($type, $entity);

        return $this->render('InstinctUserBundle:Role:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView(),
                )
            );
    }

    /**
     * Creates a new Role entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = new Role();
        $type   = new RoleType($em);
        $form   = $this->createForm($type, $entity);

        $form->bind($request);

        if ($form->isValid())
        {
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('instinct_user_admin_role_show',
                    array(
                        'id' => $entity->getId()
                        )
                    )
                );
        }

        return $this->render("InstinctUserBundle:Role:new.html.twig",
            array(
                'entity' => $entity,
                'form'   => $form->createView(),
                )
            );
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     * @since v0.0.2-dev
     *
     * @param Role $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Role $id)
    {
        $em       = $this->getDoctrine()->getManager();
        $type     = new RoleType($em);
        $editForm     = $this->createForm($type, $id);
        $deleteForm = $this->createDeleteForm($id->getId());

        return $this->render("InstinctUserBundle:Role:edit.html.twig",
            array(
                'entity'      => $id,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Edits an existing Role entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @param Role $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Role $id)
    {
        $em         = $this->getDoctrine()->getManager();
        $type       = new RoleType($em);
        $editForm   = $this->createForm($type, $id);
        $deleteForm = $this->createDeleteForm($id->getId());

        $editForm->bind($request);

        if ($editForm->isValid())
        {
            $em->persist($id);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('instinct_user_admin_role_edit',
                    array('id' => $id->getId())
                    )
                );
        }

        return $this->render("InstinctUserBundle:Role:edit.html.twig",
            array(
                'entity'      => $id,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                )
            );
    }

    /**
     * Deletes a Role entity.
     *
     * @since v0.0.2-dev
     *
     * @param Request $request
     * @param Role $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Role $id)
    {
        $form = $this->createDeleteForm($id->getId());

        $form->bind($request);

        if ($form->isValid()) {
            $em->remove($id);
            $em->flush();
        }

        return $this->redirect(
            $this->generateUrl('instinct_user_admin_role_index')
            );
    }

    /**
     * @since v0.0.2-dev
     *
     * @param integer $id <p>Role id</p>
     * @return FormBuilder
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
