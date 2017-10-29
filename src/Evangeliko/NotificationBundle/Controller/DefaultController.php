<?php

namespace Evangeliko\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvangelikoNotificationBundle:Default:index.html.twig');
    }
}
