<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

class ColumnFactory {

	protected $columnRegistry;
	
	public function __construct(ColumnRegistry $columnRegistry){
		
		$this->columnRegistry = $columnRegistry;
	}
	
	public function create($type, array $options = array()) {
		
		$types = $this->getTypeList($type);
		
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
			
			$column = $type->createColumn($options);
			
			if ($column) {
				
				break;
			}
		}
		
		foreach ($types as $type) {
			
			$type->buildColumn($column, $options);
		}
		
		return $column;
	}
	
	public function getType($name){
	
		return $this->columnRegistry->get($name);
	}
	
	public function addType(ColumnTypeInterface $type){
	
		$this->columnRegistry->set($type);
		return $this;
	}
	
	public function getTypeList($type){
	
		$type = $this->resolveType($type);
		$types = array($type);
	
		while ($type = $type->getParent()) {
				
			$type = $this->resolveType($type);
			array_unshift($types, $type);
		}
	
		return $types;
	}
	
	public function resolveType($type){
	
		if ($type instanceof ColumnTypeInterface) {
				
			return $type;
		}
	
		return $this->getType($type);
	}
}
