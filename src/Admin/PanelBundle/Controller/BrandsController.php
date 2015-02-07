<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository('AutoCatalogBundle:Brand');
        $model = $em->getRepository('AutoCatalogBundle:Model');
        $generation = $em->getRepository('AutoCatalogBundle:Generation');

        $brand_avg_filling = $brand->getAvgFilling()[1];
        $model_avg_filling = $model->getAvgFilling()[1];
        $generation_avg_filling = $generation->getAvgFilling()[1];

        //dump($brand->getAvgFilling());
        return $this->render('AdminPanelBundle:Brands:index.html.twig', array(
            'popular_brands' => $brand->getPopularBrands(),
            'unpopular_brands' => $brand->getUnpopularBrands(),
            'all_avg_filling'   =>  ($brand_avg_filling / 10 + $model_avg_filling + $generation_avg_filling) / 3,
            'brands_avg_filling'   => $brand_avg_filling,
            'models_avg_filling'   => $model_avg_filling,
            'generations_avg_filling'   => $generation_avg_filling
        ));
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
