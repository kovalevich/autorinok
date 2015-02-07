<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GenerationsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Default:index.html.twig');
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AutoCatalogBundle:Generation');

        $brand = $repository->find($id);

        return $this->render('AdminPanelBundle:Generations:edit.html.twig', array(
            'generation' => $brand
        ));
    }
}
