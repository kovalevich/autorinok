<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModelsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Default:index.html.twig');
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AutoCatalogBundle:Model');

        $brand = $repository->find($id);

        return $this->render('AdminPanelBundle:Models:edit.html.twig', array(
            'model' => $brand
        ));
    }
}
