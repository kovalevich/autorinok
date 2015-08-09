<?php

namespace Auto\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Brand');

        return $this->render('AutoCatalogBundle:Default:index.html.twig', array(
            'brands' => $repo->findAll()
        ));
    }

    public function catalogItemAction($brand_alias = null, $model_alias = null, $generation_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $repo_ads = $em->getRepository('AutoUsedBundle:Ad');
        $repo_brands = $em->getRepository('AutoCatalogBundle:Brand');
        $repo_models = $em->getRepository('AutoCatalogBundle:Model');
        $repo_generations = $em->getRepository('AutoCatalogBundle:Generation');
        $by = array();

        if($brand_alias !== null){
            if(!$brand = $repo_brands->findOneByAlias($brand_alias))
                throw new NotFoundHttpException("Такой страницы нет на сайте");
            $by['brand'] = $brand->getId();
            if($model_alias !== null){
                if(!$model = $repo_models->findOneBy(array(
                    'alias' => $model_alias,
                    'brand' => $brand->getId()
                )))
                    throw new NotFoundHttpException("Такой страницы нет на сайте");
                $by['model'] = $model->getId();
            }
            if($generation_id !== null){
                if(!$generation = $repo_generations->findOneBy(array(
                    'id' => $generation_id,
                    'model' => $model->getId()
                )))
                    throw new NotFoundHttpException("Такой страницы нет на сайте");
                $by['generation'] = $generation->getId();
            }
        }
        else{
            throw new NotFoundHttpException("Такой страницы нет на сайте");
        }

        return $this->render('AutoCatalogBundle:Default:item.html.twig', array(
            'brand'         => isset($brand) ? $brand : null,
            'model'         => isset($model) ? $model : null,
            'generation'    => isset($generation) ? $generation : null,
            'description'   => isset($generation) && strlen($generation->getText()) ? $generation->getText() :
                                    isset($model) && strlen($model->getText()) ? $model->getText() : $brand->getText(),
            'ads'           => $repo_ads->findBy($by, array('created' => 'DESC'), 7),
            'count_ads'     => $repo_ads->getCountByParams($by)
        ));
    }
}
