<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

class DateTimeTransformer extends AbstractDataTransformer{

	public function transform($data, $originalData){
		
		if (is_scalar($data)) {
			
			$data = new \DateTime(is_int($data) ? '@' . $data : $data);
		}
		
		if (!$data instanceof \DateTime) {
			
			throw new \InvalidArgumentException('$data must be an instance of DateTime, a valid date string or an integer timestamp');
		}
		
		return $data->format($this->getOption('format'));
	}
	
	public function getOptionsResolver(){
		
		return parent::getOptionsResolver()
			->setOptional(array('format'))
			->setDefaults(array('format' => 'Y-m-d H:i:s'))
		;
		
	}
}
