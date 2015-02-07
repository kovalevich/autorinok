<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class AjaxController extends Controller
{
    protected $serializer;
    public function __construct(){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }
    public function CategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BlogPublicationsBundle:Category');

        $arr = [array(
            'value' => '',
            'text'  => 'Нет категории'
        )];
        foreach($categories->findAll() as $cat)
        {
            $arr[] = array(
                'value'    => $cat->getId(),
                'text'  => $cat->getTitle()
            );
        }
        return new JsonResponse($arr);
    }

    public function PublicationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Publication');

        $arr = array();
        $params = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $publications = $repository->getPublicationsWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($publications as $publication){
            $arr[] = array(
                'id'    => $publication->getId(),
                'title' => '<a href="' . $this->generateUrl('admin_publication_edit_exist_publication', array(
                        'id' => $publication->getId()
                    )) . '">' . $publication->getTitle() . '</a>',
                'user'  => $publication->getUser()->getUserName(),
                'category'  => $publication->getCategory() ? $publication->getCategory()->getTitle() : '-',
                'created'   => $publication->getCreated()->format('d.m.Y'),
                'delete'    => '<a href="' . $this->generateUrl('admin_article_delete', array(
                        'id' => $publication->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function ThemesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Theme');

        $arr = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $themes = $repository->getThemesWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($themes as $theme){
            $arr[] = array(
                'id'    => $theme->getId(),
                'title' => $theme->getTitle(),
                'delete'    => '<a href="' . $this->generateUrl('admin_theme_delete', array(
                        'id' => $theme->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function TagsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Theme');

        $arr = array();
        if($request->get('mode') == 'init') {
            $words = explode(',', urldecode($request->get('word')));
            foreach ($words as $word) {
                $tags = $repository->getAllByTitle($word);

                foreach ($tags as $tag)
                {
                    $arr[] = array(
                        'tagName' => $tag->getTitle(),
                        'tagId'     => $tag->getId()
                    );
                }
            }
        }
        else {
            $tags = $repository->getThemesWithParams(urldecode($request->get('word')));
            foreach ($tags as $tag)
            {
                $arr[] = array(
                    'tagName' => $tag->getTitle(),
                    'tagId'     => $tag->getId()
                );
            }
        }

        return new JsonResponse($arr);
    }
}
