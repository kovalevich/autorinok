<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Blog\PublicationsBundle\Entity\Publication;
use Blog\PublicationsBundle\Entity\Theme;
use Symfony\Component\HttpKernel\DataCollector\TimeDataCollector;
use Auto\CatalogBundle\Entity\Brand;
use Auto\CatalogBundle\Entity\Model;

class EditController extends Controller
{
    public function entityAction(Request $request, $entity_name)
    {
        $id = $request->get('pk');
        $class_name = ucfirst($entity_name);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AutoCatalogBundle:' . $class_name)->find($id);

        if (!$entity) {
            $entity = new $class_name();
        }

        $name = $request->get('name');
        $value = $request->get('value');

        $method = 'set'.ucfirst($name);
        $entity->$method($value);

        $em->persist($entity);
        $em->flush();

        if($entity_name == 'model' || $entity_name == 'generation')
        {
            $filling = $entity->getFilling();
        }

        return new JsonResponse(array(
            'id'=> $entity->getId(),
            'filling' => isset($filling) ? $filling : null
        ));
    }

    public function categoryAction(Request $request)
    {
        if($id = $request->get('pk')) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('BlogPublicationsBundle:Category')->find($id);

            if (!$product) {
                return new JsonResponse(array(
                    'error'=> 'Категоря не найдена'
                ));
            }
            $method = 'set'.ucfirst($request->get('name'));
            $product->$method($request->get('value'));
            $em->flush();
        }

        return new JsonResponse(array(
            'id'=> $request->get('pk')
        ));
    }

    public function brandAction(Request $request)
    {
        $id = $request->get('pk');

        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository('AutoCatalogBundle:Brand')->find($id);

        if (!$brand) {
            $brand = new Brand();
        }

        $name = $request->get('name');
        $value = $request->get('value');

        if($name == 'text' || $name == 'title' || $name == 'alias')
            $value = urldecode($value);

        $method = 'set'.ucfirst($name);
        $brand->$method($value);

        $em->persist($brand);
        $em->flush();

        return new JsonResponse(array(
            'id'=> $brand->getId(),
            'filling' => $brand->getFilling()
        ));
    }

    public function publicationAction(Request $request)
    {
        $id = $request->get('pk');

        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Publication')->find($id);

        if (!$publication) {
            $publication = new Publication();
            $publication->setCreated(new \DateTime('now'));
        }

        $name = $request->get('name');
        $value = $request->get('value');

        if($name == 'category')
        {
            $value = $value !== '' ? $em->getReference('BlogPublicationsBundle:Category', $value) : null;
        }

        if($name == 'text' || $name == 'title' || $name == 'slug')
            $value = urldecode($value);

        $method = 'set'.ucfirst($name);
        $publication->$method($value);

        $publication->setModified(new \DateTime('now'));

        $em->persist($publication);
        $em->flush();

        return new JsonResponse(array(
            'id'=> $publication->getId()
        ));
    }

    public function themeAction(Request $request)
    {
        $id = $request->get('pk');

        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('BlogPublicationsBundle:Theme')->find($id);

        if (!$theme) {
            $theme = new Theme();
        }

        $name = $request->get('name');
        $value = $request->get('value');

        $value = urldecode($value);

        $method = 'set'.ucfirst($name);
        $theme->$method($value);

        $em->persist($theme);
        $em->flush();

        return new JsonResponse(array(
            'id'=> $theme->getId()
        ));
    }
}
