<?php

namespace Instinct\Bundle\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('date')
            ->add('autor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Instinct\Bundle\NewsBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'instinct_bundle_newsbundle_articletype';
    }
}
