<?php

namespace Instinct\Bundle\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InstinctNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
