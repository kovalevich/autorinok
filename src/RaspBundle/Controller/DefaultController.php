<?php

namespace RaspBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;

class DefaultController extends Controller
{

    public function indexAction()
    {

        return $this->render('RaspBundle:default:index.html.twig');
    }

    public function ajaxAction(Request $request)
    {
        $url = $request->get('url');
        $content = file_get_contents($url . ($request->get('term') ? '?term=' . $request->get('term') : ''));
        return new Response($content);
    }

    public function routeAction(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $from_exp = $request->get('from_exp');
        $from_esr = $request->get('from_esr');

        $to_exp = $request->get('to_exp');
        $to_esr = $request->get('to_esr');

        $date = $request->get('orig_date');

        $content = file_get_contents(sprintf("http://rasp.rw.by/ru/route/?from=%s&from_exp=%s&from_esr=%s&to=%s&to_exp=%s&to_esr=%s&date=%s", 
                $from, $from_exp, $from_esr, $to, $to_exp, $to_esr, $date
            )
        );

        $crawler = new Crawler($content);

        //$rows = $crawler->filter('tr[class="b-train"]')->extract();
        $rows = $crawler->filter('tbody.schedule_list > tr.b-train')->each(function (Crawler $node, $i) {
            return $node;
        });

        $trains = array();
        foreach($rows as $row) {
            if(!$row->filter('.train_id')) continue;
            $trains[] = array(
                'id'                => $row->filter('.train_id')->text(),
                'started'             => strstr($row->attr('class'), 'started') ? true : false,
                'train_description' => $row->filter('.train_description')->text(),
                'train_start_time'  => $row->filter('.train_start-time')->text(),
                'train_end_time'  => $row->filter('.train_end-time')->text(),
                'train_time_total'  => $row->filter('.train_time-total')->text(),
                'name'              => $row->filter('.train_name > a.train_text')->text(),
            );
        }
        return $this->render('RaspBundle:default:route.html.twig', array(
            'items'      => $trains
        ));
    }
}

