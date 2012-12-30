<?php
namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AddRenderersPass implements CompilerPassInterface {
	
	public function process(ContainerBuilder $container) {

		if (!$container->hasDefinition('yjv.report_rendering.renderer_registry')) {
			
			return;
		}
		
		$registryDefinition = $container->getDefinition('yjv.report_rendering.renderer_registry');
		
		foreach ($container->findTaggedServiceIds('yjv.report_renderer') as $id => $attributes) {
			
			$registryDefinition->addMethodCall('set', array(new Reference($id)));
		}
	}
}
