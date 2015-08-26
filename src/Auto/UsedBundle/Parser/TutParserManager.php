<?php
namespace Auto\UsedBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;

class TutParserManager
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
        $ad['name'] = preg_replace('/([\d]{4,})(?!.+\d{4}.+).+$/', '', $crawler->filter('#title_h1')->text());
        //$ad['price'] = preg_replace('/\D/', '', $crawler->filter('div.b-info > div.price')->text());
        $ad['price'] = $crawler->filter('div.b-info > span[itemprop="priceSpecification"] > meta[itemprop="price"]')->attr('content');
        $ad['currency'] = $crawler->filter('div.b-info > span[itemprop="priceSpecification"] > meta[itemprop="priceCurrency"]')->attr('content');
        $ad['phones'] = array();

        $phones_codes = $crawler->filter('span.phone-code');
        $phones = $crawler->filter('span.phone-number');

        if(count($phones_codes) > 0 && count($phones_codes) == count($phones)) {
            foreach($phones_codes as $i => $code)
            {
                $ad['phones'][$i] = array('code' => $this->convert_phone_number($code->textContent));
            }
            foreach($phones as $i => $phone)
            {
                $ad['phones'][$i]['number'] = preg_replace('/\D/', '', $this->convert_phone_number($phone->textContent));
            }
        }

        # достаем имя
        $ad['seller'] = $crawler->filter('div.contact > meta[itemprop="name"]')->attr('content');
        # достаем обмен-торг
        $text = $crawler->filter('div.b-info > ul.label_list')->valid() ? $crawler->filter('div.b-info > ul.label_list')->text() : '';
        $ad['exchange'] = strstr($text, 'Обмен') ? true : false;
        $ad['auction'] = strstr($text, 'Торг') ? true : false;

        $ad['description'] = $crawler->filter('div.user_text')->text();

        $info = $crawler->filter('div.main_text > h2')->text();
        $loc = $crawler->filter('div.main_text > p')->text();

        $ad['location'] = $loc;

        if(preg_match('/(\d+) год/', $info, $matches))
            $ad['year'] = $matches[1];

        if(preg_match('/(седан|универсал|хетчбэк|минивэн|купе|внедорожник|кроссовер|кабриолет|пикап|лимузин)/', $crawler->filter('#title_h1')->text(), $matches))
            $ad['body'] = $matches[1];

        if(preg_match('/пробег ([0-9 ]+) км/', $info, $matches))
            $ad['millage'] = str_replace(' ', '', $matches[1]);

        if(preg_match('/(\d{1,}\.\d{1,})\sл/', $info, $matches))
            $ad['volume'] = $matches[1];

        if(preg_match('/(механика|автомат|вариатор)/', $info, $matches))
            $ad['transmission'] = $matches[1];

        if(preg_match('/(Бензин|Дизель|Гибрид)/', $info, $matches))
            $ad['engine'] = $matches[1];

        if(preg_match('/(задний|передний|полный)/', $info, $matches))
            $ad['road'] = $matches[1];

        $info = $crawler->filter('div.main_text > p')->text();
        $info = explode(',', $info);
        $ad['city'] = $info[0];

        # достаем опции
        $params = $crawler->filter('ul.b-param')->text();
        $ad['option1'] = preg_match('/Кондиционер/', $params) ? true : false; # кондей
        $ad['option2'] = preg_match('/Климат-контроль/', $params) ? true : false; # климат
        $ad['option3'] = preg_match('/Обивка кожей/', $params) ? true : false; # кожа
        $ad['option4'] = preg_match('/Легкосплавные/', $params) ? true : false; # литье
        $ad['option5'] = preg_match('/ксеноновые/', $params) ? true : false; # ксенон
        $ad['option6'] = preg_match('/Парктроники/', $params) ? true : false; # парктроник
        $ad['option7'] = preg_match('/Обогрев сидений/', $params) ? true : false; # обогрев седла
        $ad['option8'] = preg_match('/ESP/', $params) ? true : false; # контроль стабилизации
        $ad['option9'] = preg_match('/Навигационная система/', $params) ? true : false; #  Навигации
        $ad['option10'] = preg_match('/Громкая связь/', $params) ? true : false; # громкая связь
        $ad['option11'] = preg_match('/Климат-контроль/', $params) ? true : false; # круиз
        $ad['option12'] = preg_match('/ABS/', $params) ? true : false; # АБС
        $ad['option13'] = preg_match('/Подушки безопасности/', $params) ? true : false; # подушки
        $ad['option14'] = preg_match('/Центральный замок/', $params) ? true : false; # центральный замок
        $ad['option15'] = preg_match('/Сигнализация/', $params) ? true : false; # сигналка
        $ad['option16'] = preg_match('/Люк/', $params) ? true : false; # люк
        $ad['option17'] = false;
        $ad['option18'] = false;
        $ad['option19'] = false;
        $ad['option20'] = false;

        # достаем картинки
        $ad['images'] = array();

        $images = $crawler->filter('div.thumb-slide a')->extract(array('href'));
        if(count($images))
            $ad['images'] = $images;

        $ad['parse_site'] = 'a.tut.by';
        preg_match('/(\d+).html/', $url, $matches);
        $ad['parse_id'] = $matches[1];

        #var_dump($ad);
        return $ad;
    }

    private function convert_phone_number($s){
        $e = array();
        $i=array(); $k=array(); $v=array();
        $r = '';

        $n = array(
            array(65, 91),
            array(97, 123),
            array(48, 58),
            array(43, 44),
            array(47, 48),
        );

        foreach ($n as $z) {
            for ($i = $z[0]; $i < $z[1]; $i++) {
                $v[] = chr($i);
            }
        }
        for ($i = 0; $i < 64; $i++) {
            $e[$v[$i]] = $i;
        }
        for ($i = 0; $i < strlen($s); $i += 72) {
            $b = 0;
            $c = 0; $x = 0; $l = 0;
            $o = substr($s, $i, $i + 72);
            for ($x = 0; $x < strlen($o); $x++) {
                if($o[$x] == '=') continue;
                $c = $e[$o[$x]];
                $b = ($b << 6) + $c;
                $l += 6;
                while ($l >= 8) {
                    $r .= chr(($this->zeroFill($b, $l -= 8)) % 256);
                }
            }
        }
        return $r;
    }

    function zeroFill($a,$b) {
        if ($a >= 0) {
            return bindec(decbin($a>>$b)); //simply right shift for positive number
        }

        $bin = decbin($a>>$b);

        $bin = substr($bin, $b); // zero fill on the left side

        $o = bindec($bin);
        return $o;
    }

}