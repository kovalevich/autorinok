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
                'class'             => 'main-menu',
            )
        ));

        $menu->addChild('Главная', array('route' => 'home'))
            ->setAttribute('icon', 'fa fa-home');

        $menu->addChild('Поиск объявлений', array('route' => 'used_homepage'))
            ->setAttribute('icon', 'fa fa-car');


        return $menu;
    }
}