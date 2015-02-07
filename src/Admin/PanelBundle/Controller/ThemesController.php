<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blog\PublicationsBundle\Entity\Theme;

class ThemesController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Themes:index.html.twig');
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Publication')->find($id);

        if (!$publication) {
            throw $this->createNotFoundException(
                'No publication found for id '.$id
            );
        }

        return $this->render('AdminPanelBundle:Publications:edit.html.twig', array(
            'publication' => $publication
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Theme')->find($id);

        if (!$publication) {
            throw $this->createNotFoundException(
                'No publication found for id '.$id
            );
        }

        $em->remove($publication);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_panel_themes'));
    }
}
