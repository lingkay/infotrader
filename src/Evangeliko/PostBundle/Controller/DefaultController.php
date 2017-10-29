<?php

namespace Evangeliko\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvangelikoPostBundle:Default:index.html.twig');
    }
}
