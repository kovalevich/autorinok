<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Auto\UsedBundle\Entity;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PagesController extends Controller
{

    public function automobileAction($brand_alias = null, $model_alias = null, $generation_id = null)
    {
        if($generation_id !== null) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AutoCatalogBundle:Generation');
            $generation = $entity->find($generation_id);

            if(!$generation || $generation->getModel()->getAlias() !== $model_alias || $generation->getModel()->getBrand()->getAlias() !== $brand_alias)
                throw new NotFoundHttpException("Такой страницы нет на сайте");

            return $this->render('AppBundle:pages:automobile-generation.html.twig', array(
                'generation' => isset($generation) ? $generation : null
            ));
        }

        if($model_alias !== null) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AutoCatalogBundle:Model');
            $model = $entity->findOneByAlias($model_alias);

            if(!$model || $model->getBrand()->getAlias() !== $brand_alias)
                throw new NotFoundHttpException("Такой страницы нет на сайте");

            return $this->render('AppBundle:pages:automobile-model.html.twig', array(
                'model' => isset($model) ? $model : null
            ));
        }

        if($brand_alias !== null)
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AutoCatalogBundle:Brand');
            $brand = $entity->findOneByAlias($brand_alias);

            if(!$brand)
                throw new NotFoundHttpException("Такой страницы нет на сайте");

            return $this->render('AppBundle:pages:automobile-brand.html.twig', array(
                'brand' => isset($brand) ? $brand : null
            ));
        }

        throw new NotFoundHttpException("Такой страницы нет на сайте");
    }
}
