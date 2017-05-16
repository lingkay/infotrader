<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Doctrine\DBAL\DBALException;

class UserController extends Controller
{
	protected $request;

	public function indexAction(Request $request)
	{
		$this->request = $request;

		$twig = "CoreUserBundle:User:index.html.twig";

		return $this->render($twig);
	}
}