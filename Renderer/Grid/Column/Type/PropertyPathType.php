<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\AbstractColumnType;

class PropertyPathType extends AbstractColumnType{

	public function getParent() {
		
		return 'escaped_column';
	}
	
	public function getName() {
		
		return 'property_path';
	}
	
	public function buildColumn(ColumnInterface $column, array $options){
		
		$dataTransformer = new PropertyPathTransformer();
		$dataTransformer->setOptions(array(
				'path' => $options['path'],
				'required' => $options['required'],
				'empty_value' => $options['empty_value']
		));
		$column->appendDataTransformer($dataTransformer);
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		
		$resolver
			->setDefaults(array(
					'path' => null,
					'required' => true,
					'empty_value' => '' 
			))	
			->setAllowedTypes(array(
					'path' => 'string',
					'required' => 'bool',
					'empty_value' => 'string'
			))	
		;
	}
}
