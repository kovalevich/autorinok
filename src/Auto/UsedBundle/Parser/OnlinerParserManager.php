<?php
namespace Auto\UsedBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;

class OnlinerParserManager
{
    public function __construct()
    {
    }

    public function parse($url)
    {
        $html = file_get_contents($url);

        $ad = array(
            'name'      => null,
            'price'     => null
        );

        $crawler = new Crawler($html);

        $ad['name'] = preg_replace('/&nbsp;/', ' ', preg_replace('/(^\s{1,})|(\s{1,}$)/', '', $crawler->filter('.autoba-fastchars-ttl')->text()));

        $ad['price'] = preg_replace('/\D/', '', $crawler->filter('span.cost > strong')->text());
        #$ad['currency'] = $crawler->filter('div.b-info > div.price > meta[itemprop="priceCurrency"]')->attr('content');
        $ad['currency'] = 'б.р.';

        $phone = $crawler->filter('div.col > span.c-bl')->text();
        $code = preg_match('/(\+\d{3})/', $phone, $matches) ? $matches[0] : '';
        $ad['phones'][0] = array(
            'code' => $code,
            'number' => preg_replace('/(\\' . $code . ')|\D/', '',$phone)
        );

        $ad['seller'] = $crawler->filter('span.mtauthor-name')->text();

        # достаем обмен-торг
        $ad['exchange'] = $crawler->filter('div.autoba-hd-details > span.c-change')->valid() ? true : false;
        $ad['auction'] = $crawler->filter('div.autoba-hd-details > span.c-torg')->valid() ? true : false;

        $ad['location'] = $crawler->filter('div.autoba-msglongcont > p')->eq(2)->text();

        //$ad['description'] = $crawler->filter('div.user_text')->text();

        $ad['year'] = $crawler->filter('span.year > strong')->text();
        $ad['millage'] = preg_replace('/\D/', '', $crawler->filter('span.dist > strong')->text());

        $info = $crawler->filter('div.autoba-msglongcont > p')->eq(1)->text();

        $ad['volume'] = preg_replace('/\D/', '', $info) * 100;
        $ad['body'] = $info;
        $ad['transmission'] = $info;
        $ad['engine'] = $info;
        $ad['road'] = $info;

        $ad['description'] = $crawler->filter('div.autoba-msglongcont > p')->eq(4)->html();

        # достаем опции
        $params = $crawler->filter('div.autoba-viewoptions > ul > li')->each(function (Crawler $node, $i) {
            return $node->attr('class') != 'none' ? $node->text() : false;
        });
        $params = implode(', ', $params);
        $ad['option1'] = preg_match('/Кондиционер/', $params) ? true : false; # кондей
        $ad['option2'] = preg_match('/Климат-контроль/', $params) ? true : false; # климат
        $ad['option3'] = preg_match('/Кожаный салон/', $params) ? true : false; # кожа
        $ad['option4'] = preg_match('/Легкосплавные диски/', $params) ? true : false; # литье
        $ad['option5'] = preg_match('/Ксенон/', $params) ? true : false; # ксенон
        $ad['option6'] = preg_match('/Парктроник/', $params) ? true : false; # парктроник
        $ad['option7'] = preg_match('/Подогрев сидений/', $params) ? true : false; # обогрев седла
        $ad['option8'] = preg_match('/Система контроля стабилизации/', $params) ? true : false; # контроль стабилизации
        $ad['option9'] = preg_match('/Навигация/', $params) ? true : false; #  Навигации
        $ad['option10'] = preg_match('/Громкая связь/', $params) ? true : false; # громкая связь
        $ad['option11'] = false;
        $ad['option12'] = false;
        $ad['option13'] = false;
        $ad['option14'] = false; # центральный замок
        $ad['option15'] = false; # сигналка
        $ad['option16'] = false; # люк
        $ad['option17'] = false;
        $ad['option18'] = false;
        $ad['option19'] = false;
        $ad['option20'] = false;

        $images = $crawler->filter('div.autoba-msgphotos-slider-area > table > tr > td')->each(function (Crawler $node, $i) {
            $img = $node->filter('a > img');
            return preg_replace('/100x100/', 'original', $img->attr('src'));
        });
        if(count($images))
            $ad['images'] = $images;
        else $ad['images'] = array();

        $ad['parse_site'] = 'ab.onliner.by';
        $ad['parse_id'] = preg_match('/(\d+)/', $url, $matches) ? $matches[1] : 0;

        return $ad;
    }

}