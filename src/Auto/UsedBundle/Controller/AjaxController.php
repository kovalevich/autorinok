<?php

namespace Auto\UsedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    public function adsAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');

        return $this->render('AutoUsedBundle:Ajax:ads.html.twig', array('items' => $repo->findAdsByParams($request->query, $page)));
    }

    public function refreshAdsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $limit = $this->container->getParameter('ads.count_on_page');
        $page = $request->get('page');

        if(!is_numeric($page) || $page < 1) $page = 1;

        $query = $em->getRepository('AutoUsedBundle:Ad')->getPage($page, $limit, $request->query);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('AutoUsedBundle:Ajax:page.html.twig', array(
            'pagination' => $pagination
        ));
    }
}