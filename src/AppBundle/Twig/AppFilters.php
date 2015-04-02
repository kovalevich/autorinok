<?php
namespace AppBundle\Twig;

class AppFilters extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('number', array($this, 'numberFilter')),
            new \Twig_SimpleFilter('photo', array($this, 'photoFilter')),
            new \Twig_SimpleFilter('options', array($this, 'optionsFilter')),
            new \Twig_SimpleFilter('memorySize', array($this, 'memorySizeFilter')),
        );
    }

    public function optionsFilter($ad, $type)
    {
        switch ($type){
            case 'short':
                $options = array();
                if($ad->getYear()) {
                    $options[] = $ad->getYear() . ' г.в.';
                }
                $engine = '';
                if($ad->getEngine()) {
                    $engine .= $ad->getEngine();
                }
                if($ad->getVolume()) {
                    $engine .= ' ' . round($ad->getVolume() / 1000, 1) . ' л';
                }
                if($engine) $options[] = $engine;

                return implode(', ', $options);
                break;
            case 'long': break;
            default: return '';
        }
    }


    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ' ')
    {
        if($number <= 1000000) {
            $postfix = ' $';
        }
        else {
            $postfix = ' млн.руб.';
            $number = round($number / 1000000, 2);
        }

        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price . $postfix;

        return $price;
    }

    public function numberFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return number_format($number, $decimals, $decPoint, $thousandsSep);
    }

    public function photoFilter($photos, $number, $size = 'min')
    {
        if(count($photos) > $number){
            return str_replace('photo', 'photo-size-' . $size, $photos[$number]);
        }
        else return '';
    }

    public function memorySizeFilter($size)
    {
        $i=0;
        $iec = array("B", "Kb", "Mb", "Gb", "Tb");
        while (($size/1024)>1) {
            $size=$size/1024;
            $i++;}
        return(round($size,1)." ".$iec[$i]);
    }

    public function getName()
    {
        return 'app_filters';
    }
}