<?php

namespace Core\TemplateBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use stdClass;

class BaseController extends FOSRestController
{
	protected $request;

	protected function view($data = null, $statusCode = null, array $headers = array())
	{
		if($data instanceof ArrayCollection  ){
			$data = $data->map(function($item){
				return  $this->serializer($item);
			});
		}else if(is_array($data)){
			$data = array_map(function($item){
				return  $this->serializer($item);
			},$data);
		}else if($data == null){
			$data = new \stdClass();
		}
		else {
			$data = $this->serializer($data);
		}
		return View::create($data, $statusCode, $headers);
	}
	private function serializer($data){
		return  json_decode(json_encode($data->toData()), true);
	}
}