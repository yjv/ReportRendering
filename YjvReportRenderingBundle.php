<?php

namespace Yjv\Bundle\ReportRenderingBundle;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddColumnTypesPass;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddRenderersPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class YjvReportRenderingBundle extends Bundle
{
	public function build(ContainerBuilder $container) {

		$container->addCompilerPass(new AddRenderersPass());
		$container->addCompilerPass(new AddColumnTypesPass());
	}

}
