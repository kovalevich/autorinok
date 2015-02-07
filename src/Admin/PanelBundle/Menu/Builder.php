<?php

namespace Admin\PanelBundle\Menu;

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

        $menu->addChild('Статистика', array('route' => 'admin_panel_homepage'))
            ->setAttribute('icon', 'fa fa-bar-chart');

        $menu->addChild('Каталог', array('route' => 'admin_panel_brands'))
            ->setAttribute('icon', 'fa fa-folder-o');

        $menu->addChild('Блог', array('route'=> 'admin_panel_blog'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-bullhorn');

        $menu['Блог']->addChild('Публикации', array('route' => 'admin_panel_publications'))
            ->setAttribute('icon', 'fa fa-file-text-o');

        $menu['Блог']->addChild('Категории', array('route' => 'admin_panel_categories'))
            ->setAttribute('icon', 'fa fa-folder');

        $menu['Блог']->addChild('Темы', array('route' => 'admin_panel_themes'))
            ->setAttribute('icon', 'fa fa-font');

        $menu->addChild('Пользователи', array('route' => 'admin_panel_publications'))
            ->setAttribute('icon', 'fa fa-users');

        $menu->addChild('Настройки', array('route' => 'admin_panel_publications'))
            ->setAttribute('icon', 'fa fa-cog');

        $menu->addChild('Очистка')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-trash-o');

        $menu['Очистка']->addChild('Очистить кэш', array('route' => 'admin_panel_publications'))
            ->setAttribute('icon', '');

        $menu['Очистка']->addChild('Очистить очередь парсинга', array('route' => 'admin_panel_categories'))
            ->setAttribute('icon', 'fa fa-folder');


        return $menu;
    }
}