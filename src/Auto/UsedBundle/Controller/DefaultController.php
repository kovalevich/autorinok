<?php

namespace Auto\UsedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->query->get('_escaped_fragment_')) {
            $arr = explode('&', preg_replace('/.+_escaped_fragment_=/', '', $request->getUri()));
            $params = array();

            foreach ($arr as $key => $value) {
                $temp = explode('=', urldecode($value));
                if(count($temp) == 2) {
                    $params[$temp[0]] = $temp[1];
                    $request->query->set($temp[0], $temp[1]);
                }
            }
            $request->query->set('view', 'html');
            return $this->forward('AutoUsedBundle:Ajax:refreshAds', array('request' => $request));
        }
        return $this->render('AutoUsedBundle:Default:index.html.twig', array(
            'big_side_bar'  => true
        ));
    }

    public function carAction($id)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');

        $ad = $repo->findJoinedAd($id);

        return $this->render('AutoUsedBundle:Default:car.html.twig', array(
            'big_side_bar'  => true,
            'ad'            => $ad,
            'ads'           => $repo->findLikeAds($ad)
        ));
    }

    public function addAction()
    {
        return $this->render('AutoUsedBundle:Default:add.html.twig', array(

        ));
    }

    public function deleteAction()
    {
        $free = disk_free_space($_SERVER['DOCUMENT_ROOT']);
        $count = 0;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:Ad');
        while (disk_free_space($_SERVER['DOCUMENT_ROOT']) / 1000000000 < 1) {
            
            $ad = $repo->findOldAd();

            $images = $ad->getImages();
            if(count($images)) {
                foreach ($images as $k => $image) {
                    $max = str_replace('photo', 'photo-size-max', $image);
                    $medium = str_replace('photo', 'photo-size-medium', $image);
                    $min = str_replace('photo', 'photo-size-min', $image);
                    if(is_file($max)) unlink($max);
                    if(is_file($medium)) unlink($medium);
                    if(is_file($min)) unlink($min);
                }
            }

            $em->remove($ad);
            $em->flush();
            $count ++;
        }

        return new JsonResponse(array(
            'Free space'    => $free,
            'deleted'       => $count
        ));
    }

}
