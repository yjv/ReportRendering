<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeRegistry {

	protected $types = array();
	
	public function set(TypeInterface $type) {
		
		$this->types[$type->getName()] = $type;
		return $this;
	}
	
	public function get($name) {
		
		if (!isset($this->types[$name])) {
			
			throw new TypeNotFoundException($name);
		}
		
		return $this->types[$name];
	}
	
	public function all() {
		
		return $this->types;
	}
	
	public function has($name) {
		
		try {
			
			$this->get($name);
			return true;
		} catch (TypeNotFoundException $e) {
			
			return false;
		}
	}
}
