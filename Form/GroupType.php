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

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class GroupType extends AbstractType
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
        $builder
        ->add('name')
        ->add('roles', 'choice',
            array(
                'choices' => $this->om
                                  ->getRepository('InstinctUserBundle:Role')
                                  ->findAll(),
                'required' => false,
                'multiple' => true,
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
            'data_class' => 'Instinct\Bundle\UserBundle\Entity\Group',
            'intention'  => 'group',
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
        return 'instinct_bundle_userbundle_grouptype';
    }
}
