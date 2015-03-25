<?php

namespace Auto\UsedBundle\Controller;

use Auto\UsedBundle\Entity\Ad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\DomCrawler\Crawler;
use Auto\UsedBundle\Entity\MostParsed;

class ParserController extends Controller
{
    protected $serializer;

    public function __construct(){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function ParseListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AutoUsedBundle:MostParsed');

        $count = 0;

        if($this->container->getParameter('parser.parse_tyt_by') === true)
        {
            $url = 'http://a.tut.by/get.php?conditions%5B%5D=2&m=search';
            $html = file_get_contents($url);
            $crawler = new Crawler($html);

            $list = $crawler->filter('a[class="model"]')->extract(array('href'));

            foreach($list as $item)
            {
                if($repo->findOneByParseKey(md5('tut'.$item))) break;

                $most_parsed = new MostParsed();
                $most_parsed->setSite('a.tut.by');
                $most_parsed->setIsParsed(false);
                $most_parsed->setParseId($item);
                $most_parsed->setParseKey(md5('tut'.$item));

                $em->persist($most_parsed);
                $em->flush();

                $count ++;
            }

        }

        return new JsonResponse(array(
            'count_added'   => $count
        ));
    }

    function ParseAdAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo_most_parsed = $em->getRepository('AutoUsedBundle:MostParsed');
        $repo_ad = $em->getRepository('AutoUsedBundle:Ad');


        $ad = null;
        if($most_parsed = $repo_most_parsed->findOne()){
            switch($most_parsed->getSite()){
                case 'a.tut.by': $ad = $this->container->get('used.parser.tut')->parse($most_parsed->getParseId()); break;
                default: break;
            }

            if($ad !== null)
            {
                $parser = $this->get('used.parser');

                $new_ad = new Ad();
                $new_ad->setTitle($ad['name']);

                if($brand = $parser->getBrandIdFromName($ad['name']))
                    $new_ad->setBrand($brand);
                else return new JsonResponse(array(
                    'error' => 'Не удалось распознать марку > ' . $ad['name']
                ));

                if($model = $parser->getModelIdFromName($ad['name'], $new_ad->getBrand()))
                    $new_ad->setModel($model);
                else return new JsonResponse(array(
                    'error' => 'Не удалось распознать модель > ' . $ad['name']
                ));

                if($generation = $parser->getGenerationIdByModel($new_ad->getModel(), $ad['year']))
                    $new_ad->setGeneration($generation);

                if(count($ad['phones']) == 0)
                    return new JsonResponse(array(
                        'error' => 'Не удалось распознать номер телефона > ' . $most_parsed->getParseId()
                    ));

                $new_ad->setPhones($ad['phones']);
                $new_ad->setPrice($ad['price']);
                $new_ad->setImages($parser->uploadImages($ad['images']));
                $new_ad->setYear($ad['year']);
                $new_ad->setParseId($most_parsed->getParseId());
                $new_ad->setDescription($ad['description']);

                for($i = 1; $i <= 20; $i++) {
                    $setter = 'setOption' . $i;
                    $new_ad->$setter($ad['option'.$i]);
                }

                $new_ad->setParseSite($ad['parse_site']);
                $new_ad->setParseId($ad['parse_id']);
                if(isset($ad['volume'])) $new_ad->setVolume($ad['volume']);

                $most_parsed->setIsParsed(true);
                $em->persist($most_parsed);
                $em->persist($new_ad);
                $em->flush();

                return new JsonResponse(array(
                    'success'   => $brand->getName() . ' ' . $model->getName()
                ));
            }
        }

        return new JsonResponse(array(
        ));
    }

}
