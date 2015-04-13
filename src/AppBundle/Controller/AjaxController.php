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

    public function PhoneAction($phone, $country_code)
    {
        $text = $country_code . $phone;

        if($country_code == '+375')
        {
            $code = substr($phone, 0, 2);
            if(strlen(substr($phone, 2)) == 7 && ($code == '29' || $code == '33' || $code == '44' || $code == '25'))
            {
                $text = $country_code . ' (' . $code . ') ' . substr($phone, 2, 3) . '-' . substr($phone, 5, 2) . '-' . substr($phone, 7);
            }
        }
        /* Create Imagick objects */
        $image = new \Imagick();
        $draw = new \ImagickDraw();
        $color = new \ImagickPixel('gray');
        $background = new \ImagickPixel('none'); // Transparent

        /* Font properties */
        $fonts = array(
            'Times',
            //'Times New Roman',
            'Arial',
            'Helvetica',
            'Courier',
            'Verdana',
        );
        $draw->setFont($fonts[array_rand($fonts, 1)]);
        $draw->setFontSize(15);
        $draw->setFillColor($color);
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);

        /* Get font metrics */
        $metrics = $image->queryFontMetrics($draw, $text);

        /* Create text */
        $draw->annotation(0, $metrics['ascender'], $text);

        /* Create image */
        $image->newImage($metrics['textWidth']+5, $metrics['textHeight'], $background);
        $image->setImageFormat('png');
        $image->drawImage($draw);

        $headers = array(
            'Content-Type'     => 'image/png',
        );
        return new Response($image, 200, $headers);
    }
}
