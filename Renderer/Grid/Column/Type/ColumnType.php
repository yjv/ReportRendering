<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\AbstractColumnType;

class ColumnType extends AbstractColumnType{

	public function getParent() {
		
		return false;
	}
	
	public function getName() {
		
		return 'column';
	}
	
	public function buildColumn(ColumnInterface $column, array $options){
		
		$column->setOptions(array(
				'name' => $options['name'],
				'sortable' => $options['sortable'],
				'escape_output' => $options['escape_output']
		));
		
		$column->setCellOptions(array('escape_output' => $options['escape_output']));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		
		$resolver
			->setDefaults(array(
					'escape_output' => false, 
					'sortable' => true,
					'name' => ''
			))
			->setAllowedTypes(array(

					'escape_output' => 'bool',
					'sortable' => 'bool',
					'name' => 'string'
			))
		;
	}
}
