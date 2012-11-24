<?php
namespace Instinct\Bundle\BbcodeBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig Extension for BBCode support.
 *
 * @author alexandre.quercia
 */
class InstinctBbcodeExtension extends \Twig_Extension
{
    /**
     * Container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Initialize bbcode helper
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     *
     * @return object The associated service
     */
    public function getService($id)
    {
        return $this->container->get($id);
    }

    /**
     * Get parameters from the service container
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'instinct_bbcode_init' => new \Twig_Function_Method($this, 'instinct_bbcode_init', array('is_safe' => array('html'))),
            'instinct_bbcode_stylesheet' => new \Twig_Function_Method($this, 'instinct_bbcode_stylesheet', array('is_safe' => array('html'))),
        );
    }

    /**
     * InstinctBbcode initializations
     *
     * @return string
     */
    public function instinct_bbcode_init()
    {
        return $this->getService('templating')->render('InstinctBbcodeBundle:Script:init.html.twig');
    }

    /**
     * InstinctBbcode stylesheet loader
     *
     * @return string
     */
    public function instinct_bbcode_stylesheet()
    {
        return $this->getService('templating')->render('InstinctBbcodeBundle:Style:init.html.twig');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'instinct_bbcode';
    }
}