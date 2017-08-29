<?php

namespace Evangeliko\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvangelikoTestBundle:Default:index.html.twig');
    }
}
