<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerNotFoundException;

use Yjv\BundleReportRenderingBundle\DatatTransfomer\DataTransformerInterface;

class DataTransformerRegistry {

	protected $dataTransformers = array();
	
	public function add($name, DataTransformerInterface $dataTransformer) {
		
		$this->dataTransformers[$name] = $dataTransformer;
		return $this;
	}
	
	public function get($name) {
		
		if (!isset($this->dataTransformers[$name])) {
			
			throw new DataTransformerNotFoundException($name);
		}
		
		return $this->dataTransformers[$name];
	}
}
