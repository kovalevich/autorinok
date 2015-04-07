<?php

namespace Auto\UsedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    public function adsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');

        return $this->render('AutoUsedBundle:Ajax:ads.html.twig', array('items' => $repo->findAdsByParams($request->query)));
    }

    public function countAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $count = $em->getRepository('AutoUsedBundle:Ad')->getCount($request->query);

        return new JsonResponse(array(
            'count' => $count
        ));
    }
}
