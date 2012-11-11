<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\Form\Exception\FormException;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\Form\Util\PropertyPath;

use Yjv\BUndle\ReportRenderingBundle\DataTransformer\AbstractDataTransformer;

class FormatStringTransformer extends AbstractDataTransformer{

	/**
	 * @param unknown $data
	 */
	public function transform($data, $orginalData) {

		$string = $this->getOption('format_string');
		
		if (preg_match_all('/\{([^}]*)\}/', $string, $matches)) {
			
			foreach (array_unique($matches[1]) as $path) {
				
				$propertyPath = new PropertyPath($path);
				
				try {
					
					$string = str_replace(sprintf('{%s}', $path), $propertyPath->getValue($data), $string);
				} catch (InvalidPropertyException $e) {
					
					return $this->handlePathSearchException($e);
				} catch(PropertyAccessDeniedException $e){
					
					return $this->handlePathSearchException($e);
				}
			}
		}
		
		return $string;
	}

	protected function getOptionsResolver(){
		
		return parent::getOptionsResolver()
			->setRequired(array('format_string'))
			->setOptional(array('required', 'empty_value'))
			->setDefaults(array('required' => true, 'empty_value' => ''))
			->setAllowedTypes(array(
					'format_string' => array('string'),
					'required' => array('bool'),
					'empty_value' => array('scalar')
			))
		;
	}
	
	protected function handlePathSearchException(FormException $e) {
		
			if (!$this->getOption('required')) {
				
				return $this->getOption('empty_value');
			}
				
			throw $e;
	}
}
