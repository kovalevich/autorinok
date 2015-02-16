<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegionsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Regions:index.html.twig');
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AutoCatalogBundle:Brand');

        $brand = $repository->find($id);

        return $this->render('AdminPanelBundle:Brands:edit.html.twig', array(
            'brand' => $brand
        ));
    }
}
