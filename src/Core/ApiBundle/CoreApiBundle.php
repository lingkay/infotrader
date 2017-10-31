<?php

namespace Core\ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Core\ApiBundle\DependencyInjection\Compiler\OverrideFOSOAuthServerTokenControllerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class CoreApiBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	    $container->addCompilerPass(new OverrideFOSOAuthServerTokenControllerPass());
	}
}
