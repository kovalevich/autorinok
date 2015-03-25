<?php

namespace Auto\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Brand');

        return $this->render('AutoCatalogBundle:Default:index.html.twig', array(
            'brands' => $repo->findAll()
        ));
    }
}
