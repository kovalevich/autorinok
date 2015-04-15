<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Auto\UsedBundle\Entity;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');

        return $this->render('AppBundle:default:index.html.twig', array(
            'count_new_ads' => $repo->getCountNew(),
            'count_ads' => $repo->getCount(),
            'new_ads' => $repo->findBy(array(),array('created' => 'DESC'), 7)
        ));
    }
}
