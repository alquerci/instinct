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

namespace Instinct\Bundle\UserBundle\Form;

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
     * @var ObjectManager
     */
    protected $om;

    /**
     * @since v0.0.2-dev
     *
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
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
//         $transformer = new RolesToArrayTransformer($this->om);

        $builder
        ->add('username')
//         ->add('usernameCanonical')
        ->add('email')
//         ->add('emailCanonical')
        ->add('enabled', null, array("required" => false))
//         ->add('salt')
//         ->add('password')
//         ->add('lastLogin')
//         ->add('locked')
//         ->add('expired')
//         ->add('expiresAt')
//         ->add('confirmationToken')
//         ->add('passwordRequestedAt')
        ->add('roles', 'choice',
            array(
                'choices'  => $this->om
                                   ->getRepository('InstinctUserBundle:Role')
                                   ->findAll(),
                'required' => true,
                'multiple' => true
                )
        )
//         ->add('credentialsExpired')
//         ->add('credentialsExpireAt')
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
