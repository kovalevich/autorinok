<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav',
            )
        ));

        $menu->addChild('Главная', array('route' => 'home'));

        $menu->addChild('Объявления', array('route' => 'auto_used_index'));
        $menu->addChild('Лента', array('route' => 'app_lenta'));
        $menu->addChild('Каталог', array('route' => 'auto_catalog_index'));
        $menu->addChild('Подать объвление', array('uri' => '#'));
        return $menu;
    }
}