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

        if($brand = $request->get('brand')) {
            $brand = $em->getRepository('AutoCatalogBundle:Brand')->findOneByAlias($brand);
        }
        if($model = $request->get('model')) {
            $model = $em->getRepository('AutoCatalogBundle:Model')->findOneByAlias($model);   
        }

        if($request->get('view') == 'html') {
            return $this->render('AutoUsedBundle:Ajax:page_html.html.twig', array(
                'pagination'    => $pagination,
                'brand'         => $brand,
                'model'         => $model,
                'year'          => str_replace(';', '-', $request->get('year'))
            ));
        }
        else
            return $this->render('AutoUsedBundle:Ajax:page.html.twig', array(
                'pagination'    => $pagination,
                'brand'         => $brand,
                'model'         => $model
            ));
    }

    public function countNewAdsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');
        return new JsonResponse(array(
            'count' => $repo->getCountNew()
        ));
    }
}