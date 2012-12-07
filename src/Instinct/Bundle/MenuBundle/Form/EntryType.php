<?php

namespace Instinct\Bundle\MenuBundle\Form;

use Symfony\Component\Routing\Route;

use Symfony\Component\Routing\RouteCollection;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('route', 'choice',
                array(
                    'choices'  => $this->getRoutes(),
                    'required' => true,
                    'multiple' => false
                    )
                )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Instinct\Bundle\MenuBundle\Entity\Entry'
        ));
    }

    public function getName()
    {
        return 'instinct_bundle_menubundle_entrytype';
    }

    /**
     * @since v0.0.1
     *
     * @return RouteCollection
     */
    protected function getRouteCollection()
    {
        return $this->container->get("router")->getRouteCollection();
    }

    /**
     * @since v0.0.1
     *
     * @return array
     */
    protected function getRoutes()
    {
        $choices = $this->getRouteCollection()->all();

        foreach ($choices as $routeName => $route)
        {
            if ($route instanceof Route)
            {
                if (substr($routeName, 0, 1) != "_")
                {
                    $choices[$routeName] = $routeName;

                    foreach ($route->compile()->getVariables() as $var)
                    {
                        if (!$route->hasDefault($var))
                        {
                            unset($choices[$routeName]);
                            break;
                        }
                    }
                    $_method = $route->getRequirement("_method");
                    if (preg_match("#post#i", $_method))
                    {
                        unset($choices[$routeName]);
                    }
                }
                else
                {
                    unset($choices[$routeName]);
                }
            }
            else
            {
                unset($choices[$routeName]);
            }
        }

        return $choices;
    }
}
