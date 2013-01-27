<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractColumnType implements ColumnTypeInterface {
	
	public function buildColumn(ColumnInterface $column, array $options) {}
	
	public function createColumn(array $options) {

		return new Column();
	}
	
	public function getParent() {

		return 'column';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {}
	
	public function getOptionsResolver() {

		return new OptionsResolver();
	}

}
