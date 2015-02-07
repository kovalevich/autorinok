<?php
namespace AppBundle\Twig;

class AppFilters extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('number', array($this, 'numberFilter')),
            new \Twig_SimpleFilter('memorySize', array($this, 'memorySizeFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $postfix = $number <= 1000000 ? ' $' : ' руб.';

        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price . $postfix;

        return $price;
    }

    public function numberFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return number_format($number, $decimals, $decPoint, $thousandsSep);
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