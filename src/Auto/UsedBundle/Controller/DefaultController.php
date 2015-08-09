<?php

namespace Auto\UsedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AutoUsedBundle:Default:index.html.twig', array(
            'big_side_bar'  => true
        ));
    }

    public function carAction($id)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');

        $ad = $repo->findJoinedAd($id);

        return $this->render('AutoUsedBundle:Default:car.html.twig', array(
            'big_side_bar'  => true,
            'ad'            => $ad,
            'ads'           => $repo->findLikeAds($ad)
        ));
    }

    public function addAction()
    {
        return $this->render('AutoUsedBundle:Default:add.html.twig', array(

        ));
    }

}
