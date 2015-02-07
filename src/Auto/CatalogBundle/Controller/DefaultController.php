<?php

namespace Auto\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AutoCatalogBundle:Default:index.html.twig', array('name' => $name));
    }
}
