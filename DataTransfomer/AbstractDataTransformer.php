<?php
namespace Yjv\BUndle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\BundleReportRenderingBundle\DatatTransfomer\DataTransformerInterface;

abstract class AbstractDataTransformer implements DataTransformerInterface {

	protected $options = array();
	
	public function setOptions(array $options){
		
		$this->options = $this->getOptionsResolver()->resolve($options);
		return $this;
	}
	
	/**
	 * 
	 * @return \Symfony\Component\OptionsResolver\OptionsResolver
	 */
	protected function getOptionsResolver(){
		
		return new OptionsResolver();
	}
}
