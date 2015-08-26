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
            //var_dump(count($list));

            foreach($list as $item)
            {
                //var_dump($item);
                if($repo->findOneByParseKey(md5('tut'.$item))) continue;

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

        if($this->container->getParameter('parser.parse_onliner_by') === true){
            $hostname = 'ab.onliner.by';
            $path = '/search';
            $content = '';
            // Устанавливаем соединение с сервером $hostname
            $fp = fsockopen($hostname, 80, $errno, $errstr, 30);
            // Проверяем успешность установки соединения
            if (!$fp) die('<p>'.$errstr.' ('.$errno.')</p>');

            // Данные HTTP-запроса
            $data = 'sort[]=creation_date';
            // Заголовок HTTP-запроса
            $headers = 'POST '.$path." HTTP/1.1\r\n";
            $headers .= 'Host: '.$hostname."\r\n";
            $headers .= "Content-type: application/x-www-form-urlencoded\r\n";
            $headers .= "Content-Length: ".strlen($data)."\r\n\r\n".$data."\r\n\r\n";
            $headers .= "Origin: http://ab.onliner.by\r\n";
            $headers .= "Referer: http://ab.onliner.by/\r\n";
            $headers .= "Accept: application/json, text/javascript, */*; q=0.01\r\n";
            $headers .= "X-Requested-With: XMLHttpRequest\r\n";
            $headers .= "Accept-Encoding: gzip,deflate,sdch\r\n";
            $headers .= "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4\r\n";
            $headers .= "Cookie:ouid=snyBNFNiDQWvpC9BGbJyAg==; onl_session=K95i9mHLHYxaFp3eza7f4iXV2EoZzxcVAXibQRhg%2F5AB%2F5Tkdj8fCVWeObZhdhvuZh7jrV8kqrISfkCbtM%2BndCrq4k6EzWPpsdo9X30pQXsusmYaE%2FjcO81EOJ0GLr1AEJJ8zJ8aUKzjzmOLUClRz8LV6xZPtBt8mJduuG%2FpS2AgzMGAQi8UN71B6wRgMaZ3N%2FXwJaI9FDo9Egb3xa27i4QewWrPxrwg6bjogo1oVntE%2BrjarMjlrA%3D%3D; __utma=163034604.1962427862.1398934826.1412512816.1415340104.75; __utmz=163034604.1412512816.74.27.utmcsr=onliner.by|utmccn=(referral)|utmcmd=referral|utmcct=/; currency_catalog=BYR; session=vih8bbk2fceaqmhignc8704qd7; __utmt=1; __utmt_a=1; __utma=237879006.1873782876.1398934790.1421321992.1421339556.736; __utmb=237879006.7.10.1421339556; __utmc=237879006; __utmz=237879006.1421140756.731.88.utmcsr=t.co|utmccn=(referral)|utmcmd=referral|utmcct=/bb7R4X0tZk; __utmv=237879006.|1=forum_id=405=1^2=topic_id=11197294=1^3=dev_id=section=1\r\n";
            // Отправляем HTTP-запрос серверу
            fwrite($fp, $headers);
            // Получаем ответ
            while ( !feof($fp) ) $content .= fgets($fp, 1024);
            // Закрываем соединение
            fclose($fp);
            preg_match_all('/(?<=car_)\d{1,}/', $content, $arr);

            foreach($arr[0] as $item)
            {
                if($repo->findOneByParseKey(md5('onliner'.$item))) continue;

                $most_parsed = new MostParsed();
                $most_parsed->setSite('ab.onliner.by');
                $most_parsed->setIsParsed(false);
                $most_parsed->setParseId('http://ab.onliner.by/car/' . $item);
                $most_parsed->setParseKey(md5('onliner'.$item));

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
            $most_parsed->setIsParsed(true);
            $em->persist($most_parsed);
            $em->flush();
            switch($most_parsed->getSite()){
                case 'a.tut.by': $ad = $this->container->get('used.parser.tut')->parse($most_parsed->getParseId()); break;
                case 'ab.onliner.by' : $ad = $this->container->get('used.parser.onliner')->parse($most_parsed->getParseId()); break;
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
                $new_ad->setPrice($ad['price'], $ad['currency'], $this->container->getParameter('cource'));
                $new_ad->setCurrency($ad['currency']);
                $new_ad->setImages($parser->uploadImages($ad['images']));
                $new_ad->setYear($ad['year']);
                if(isset($ad['volume']))
                    $new_ad->setVolume($ad['volume']);
                if(isset($ad['seller']))
                    $new_ad->setSeller($ad['seller']);
                if(isset($ad['engine']))
                    $new_ad->setEngine($ad['engine']);
                if(isset($ad['transmission']))
                    $new_ad->setTransmission($ad['transmission']);
                if(isset($ad['road']))
                    $new_ad->setRoad($ad['road']);
                if(isset($ad['body']))
                    $new_ad->setBody($ad['body']);
                if(isset($ad['millage']))
                    $new_ad->setMillage($ad['millage']);

                if(isset($ad['location'])){
                    $geocode = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?geocode=' . $ad['location'] . '&format=json'));
                    if(count($geocode->response->GeoObjectCollection->featureMember)) {
                        $country = $geocode->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->AddressDetails->Country->CountryName;
                        $region = $geocode->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName;
                        $city = $geocode->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->AddressDetails->Country->AdministrativeArea->Locality->LocalityName;

                        $repo_country = $em->getRepository('LocationBundle:Country');
                        $repo_region = $em->getRepository('LocationBundle:Region');
                        $repo_city = $em->getRepository('LocationBundle:City');

                        $country = $repo_country->findOneByName($country);
                        $region = $repo_region->findOneByName($region);
                        $city = $repo_city->findOneByName($city);

                        if($country)
                            $new_ad->setCountry($country);
                        if($region)
                            $new_ad->setRegion($region);
                        if($city)
                            $new_ad->setCity($city);
                    }
                }

                $new_ad->setParseId($most_parsed->getParseId());
                $new_ad->setDescription($ad['description']);

                for($i = 1; $i <= 20; $i++) {
                    $setter = 'setOption' . $i;
                    $new_ad->$setter($ad['option'.$i]);
                }

                $new_ad->setParseSite($ad['parse_site']);
                $new_ad->setParseId($ad['parse_id']);

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
