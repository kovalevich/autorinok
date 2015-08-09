<?php

namespace Auto\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{
    public function brandsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Brand');

        $brands = $repo->findAll();
        $return_arr = array();
        $i = 0;
        foreach($brands as $brand)
        {
            if($i++ > 10) break;
            $return_arr[] = array(
                'id'        => $brand->getId(),
                'alias'        => $brand->getAlias(),
                'name'      => $brand->getName(),
                'picture'   => $brand->getLogo() ? $brand->getLogo()->getImage()['path'] : null
            );
        }
        return new JsonResponse($return_arr);
    }

    public function modelsAction($brand)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoCatalogBundle:Model');
        $repo_brands = $em->getRepository('AutoCatalogBundle:Brand');

        $brand = $repo_brands->findOneByAlias($brand);
        if(!$brand) return new JsonResponse(null);

        $models = $repo->findByBrand($brand->getId());
        $return_arr = array();
        foreach($models as $model)
        {
            if(!$model->getParent())
                $return_arr[$model->getId()] = array(
                    'id'        => $model->getId(),
                    'alias'        => $model->getAlias(),
                    'name'      => $model->getName(),
                    'models' => array()
                );
            else {
                $return_arr[$model->getParent()->getId()]['models'][] = array(
                    'id'        => $model->getId(),
                    'alias'        => $model->getAlias(),
                    'name'      => $model->getName(),
                    'models' => array()
                );
            }
        }
        return new JsonResponse($return_arr);
    }

}
