<?php
namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AddColumnTypesPass implements CompilerPassInterface {
	
	public function process(ContainerBuilder $container) {

		if (!$container->hasDefinition('yjv.report_rendering.column_registry')) {
			
			return;
		}
		
		$registryDefinition = $container->getDefinition('yjv.report_rendering.column_registry');
		
		foreach ($container->findTaggedServiceIds('yjv.column_type') as $id => $attributes) {
			
			$registryDefinition->addMethodCall('set', array(new Reference($id)));
		}
	}
}
