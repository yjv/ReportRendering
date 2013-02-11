<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTypeFactory implements TypeFactoryInterface{

	protected $registry;
	
	public function createBuilder($type, array $options = array()) {
		
		$typeChain = $this->getTypeChain($type);
		$optionsResolver = $this->getOptionsResolver($typeChain);
		$options = $this->getOptions($typeChain, $optionsResolver, $options);
		$builder = $this->getBuilder($typeChain, $options);
		return $this->build($typeChain, $builder, $options);
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
	
		return new TypeChain($types);
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
	
	protected function getOptionsResolver(TypeChainInterface $typeChain) {
		
		$typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
		
		foreach ($typeChain as $type) {

			$optionsResolver = $type->getOptionsResolver();
			
			if ($optionsResolver) {
				
				break;
			}
		}
		
		if (empty($optionsResolver)) {
			
			throw new OptionsResolverNotReturnedException();
		}

		return $optionsResolver;
	}
	
	protected function getOptions(TypeChainInterface $typeChain, OptionsResolverInterface $optionsResolver, array $options) {
		
		$typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
		
		foreach ($typeChain as $type) {

			$type->setDefaultOptions($optionsResolver);
		}
		
		return $optionsResolver->resolve($options);
	}
	
	protected function getBuilder(TypeChainInterface $typeChain, array $options) {
		
		$typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
		
		foreach ($typeChain as $type) {
			
			$builder = $type->createBuilder($this, $options);

			if ($builder) {
				
				$requiredInterface = $this->getBuilderInterfaceName();
				
				if (!$builder instanceof $requiredInterface) {
					
					throw new BuilderNotSupportedException($builder, $requiredInterface);
				}
				
				break;
			}
		}

		if (empty($builder)) {
			
			throw new BuilderNotReturnedException();
		}
		
		return $builder;
	}
	
	protected function build(TypeChainInterface $typeChain, $builder, array $options) {
		
		$typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
		
		foreach ($typeChain as $type) {
			
			$type->build($builder, $options);
		}
		
		return $builder;
	}
}
