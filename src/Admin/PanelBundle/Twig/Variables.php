<?php
namespace Admin\PanelBundle\Twig;

class Variables extends \Twig_Extension
{

    public function getGlobals() {
        return array(
            'disk_free_space'           => disk_free_space($_SERVER['DOCUMENT_ROOT']),
            'disk_total_space'          => disk_total_space($_SERVER['DOCUMENT_ROOT']),
            'disk_free_space_percent'   => 100 - 100 * disk_free_space($_SERVER['DOCUMENT_ROOT']) / disk_total_space($_SERVER['DOCUMENT_ROOT'])
        );
    }

    public function getName()
    {
        return 'admin_variables';
    }
}