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

namespace Instinct\Bundle\UserBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Instinct\Bundle\UserBundle\Form\DataTransformer\RolesToArrayTransformer;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class UserType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @since v0.0.2-dev
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @since v0.0.2-dev
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $srvRole = $this->container->get("instinct_user.role");
        $roles = $srvRole->getRoles();

        foreach ($roles as $key => $role)
        {
            $choices[$role->getRole()] = $role->getRole();
        }

        $builder
        ->add('username')
        ->add('email')
        ->add('enabled', null, array("required" => false))
        ->add('roles', 'choice',
            array(
                'choices'  => $choices,
                'required' => false,
                'multiple' => true
                )
        )
        ->add('groups', null,
            array(
                'required' => false,
            )
        )
        ;
    }

    /**
     * @since v0.0.2-dev
     * @see \Symfony\Component\Form\AbstractType::setDefaultOptions()
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Instinct\Bundle\UserBundle\Entity\User'
        ));
    }

    /**
     * @since v0.0.2-dev
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     *
     * @return string
     */
    public function getName()
    {
        return 'instinct_bundle_userbundle_usertype';
    }
}
