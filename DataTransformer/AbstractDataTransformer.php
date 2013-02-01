<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDataTransformer implements DataTransformerInterface {

	protected $options = array();
	protected $resolvedOptions;
	
	public function setOptions(array $options){
		
		$this->options = $options;
		$this->resolveOptions(true);
		return $this;
	}
	
	public function getOption($name) {
		
		$this->resolveOptions();
		return $this->resolvedOptions[$name];
	}
	
	protected function resolveOptions($force = false) {
		
		if (is_null($this->resolvedOptions) || $force) {
		
			$this->resolvedOptions = $this->getOptionsResolver()->resolve($this->options);
		}
	}
	
	/**
	 * 
	 * @return \Symfony\Component\OptionsResolver\OptionsResolver
	 */
	protected function getOptionsResolver(){
		
		return new OptionsResolver();
	}
}
