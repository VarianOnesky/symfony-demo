<?php

namespace Company\Bundle\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DataBundle:Default:index.html.twig', array('name' => $name));
    }
}
