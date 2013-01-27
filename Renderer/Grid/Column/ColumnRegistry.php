<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnTypeNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnTypeInterface;

class ColumnRegistry {

	protected $types = array();
	
	public function set(ColumnTypeInterface $type) {
		
		$this->types[$type->getName()] = $type;
		return $this;
	}
	
	public function get($name) {
		
		if (!isset($this->types[$name])) {
			
			throw new ColumnTypeNotFoundException($name);
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
		} catch (ColumnTypeNotFoundException $e) {
			
			return false;
		}
	}
}
