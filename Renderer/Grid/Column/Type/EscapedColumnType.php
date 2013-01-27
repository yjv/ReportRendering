<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\AbstractColumnType;

class EscapedColumnType extends AbstractColumnType{

	public function getParent() {
		
		return 'column';
	}
	
	public function getName() {
		
		return 'escaped_column';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		
		$resolver
			->setDefaults(array(
					'escape_output' => true, 
			))		
		;
	}
}
