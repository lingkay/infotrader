<?php

namespace Evangeliko\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvangelikoAccountBundle:Default:index.html.twig');
    }
}
