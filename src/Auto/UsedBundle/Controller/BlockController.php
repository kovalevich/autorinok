<?php

namespace Auto\UsedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function brandsAction($popular)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Brand');

        $brands = $popular === true ? $repo->getPopularBrands() : $repo->getUnpopularBrands();
        return $this->render('AutoUsedBundle:Block:brands.html.twig', array('items' => $brands));
    }
}
