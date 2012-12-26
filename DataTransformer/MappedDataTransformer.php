<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

class MappedDataTransformer extends AbstractDataTransformer{
	
	/**
	 * @param unknown $data
	 */
	public function transform($data, $orginalData) {
	
		$map = $this->getOption('map');
		
		if (isset($map[$data]) || array_key_exists($data, $map)) {
			
			$value = $map[$data];
		}else{
			
			if ($this->getOption('required')) {
				
				throw new \InvalidArgumentException(sprintf('map does not contain a value for %s', $data));
			}else{
				
				$value = $this->getOption('empty_value');
			}
		}
		
		return $value;
	}
	
	protected function getOptionsResolver(){
	
		return parent::getOptionsResolver()
			->setRequired(array('map'))
			->setOptional(array('required', 'empty_value'))
			->setDefaults(array('required' => true, 'empty_value' => ''))
			->setAllowedTypes(array(
					'map' => array('array'),
					'required' => array('bool'),
					'empty_value' => array('scalar')
			))
		;
	}
}
