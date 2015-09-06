<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Auto\UsedBundle\Entity;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class MapController extends Controller
{
	public function xmlAction()
	{
		$em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Brand');

        $brands = $repo->findAll();

        $response = new Response();
		$response->headers->set('Content-Type', 'xml');

		return $this->render('AppBundle:map:xml.html.twig', array(
            'brands' => $brands
        ),$response);
	}

	public function htmlAction()
	{	
		
	}
}