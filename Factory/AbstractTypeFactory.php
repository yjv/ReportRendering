<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTypeFactory implements TypeFactoryInterface{

	protected $registry;
	
	public function createBuilder($type, array $options = array()) {
		
		$types = $this->getTypeChain($type);
		
		foreach (array_reverse($types) as $type) {
			
			$optionsResolver = $type->getOptionsResolver();
			
			if ($optionsResolver) {
				
				break;
			}
		}
		
		foreach ($types as $type) {
			
			$type->setDefaultOptions($optionsResolver);
		}
		
		$options = $optionsResolver->resolve($options);
		
		foreach (array_reverse($types) as $type) {
			
			$builder = $type->createBuilder($this, $options);
			
			if ($builder) {
				
				$requiredInterface = $this->getBuilderInterfaceName();
				
				if (!$builder instanceof $requiredInterface) {
					
					throw new BuilderNotSupportedException($builder, $requiredInterface);
				}
				
				break;
			}
		}
		
		foreach ($types as $type) {
			
			$type->build($builder, $options);
		}
		
		return $builder;
	}
	
	public function getType($name){
	
		return $this->registry->get($name);
	}
	
	public function getTypeChain($type){
	
		$type = $this->resolveType($type);
		$types = array($type);
	
		while ($type = $type->getParent()) {
				
			$type = $this->resolveType($type);
			array_unshift($types, $type);
		}
	
		return $types;
	}
	
	public function resolveType($type){
	
		if ($type instanceof TypeInterface) {
				
			return $type;
		}
	
		return $this->getType($type);
	}
	
	public function getTypeRegistry(){
		
		return $this->registry;
	}
}
