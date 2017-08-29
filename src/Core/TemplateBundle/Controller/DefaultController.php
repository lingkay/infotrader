<?php

namespace Core\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreTemplateBundle:Default:index.html.twig');
    }
}
