<?php
namespace Yjv\Bundle\ReportRenderingBundle\Twig;

class ReportRenderingExtension extends \Twig_Extension{

	public function attributes(array $attributes, array $defaults = array()) {
		
		if (isset($defaults['class']) && isset($attributes['class'])) {
			
			$attributes['class'] .= ' ' . $defaults['class'];
		}
		
		$attributes = array_replace($defaults, $attributes);
		
		$attributesString = ' ';
		
		foreach ($attributes as $name => $value) {
			
			$attributesString .= sprintf('%s="%s" ', $name, $value);
		}
		
		return $attributesString;
	}
	
	public function getFilters(){
		
		return array(

				'attributes' => new \Twig_Filter_Method($this, 'attributes', array('is_safe' => array('html')))
		);
	}
	
	public function getName() {
		
		return 'report_rendering_extension';
	}
}
