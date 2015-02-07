<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Default:index.html.twig');
    }
}
