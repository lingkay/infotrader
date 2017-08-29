<?php

namespace Evangeliko\CommunityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvangelikoCommunityBundle:Default:index.html.twig');
    }
}
