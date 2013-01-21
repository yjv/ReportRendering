<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

class ReportTypeRegistry {

	protected $types = array();
	
	public function get($name) {
		
		if (!isset($this->types[$name])) {
			
			throw new ReportTypeNotFoundException($name);
		}
		
		return $this->types[$name];
	}
	
	public function set(ReportTypeInterface $type) {
		
		$this->types[$type->getName()] = $type;
		return $this;
	}
}
