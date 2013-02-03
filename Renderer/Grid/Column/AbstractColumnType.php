<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractColumnType implements TypeInterface {
	
	final public function build($builder, array $options){
		
		return $this->buildColumn($builder, $options);
	}
	
	public function buildColumn(ColumnBuilderInterface $builder, array $options){}
	
	public function createBuilder(TypeFactoryInterface $factory, array $options) {

		$builder = new ColumnBuilder($factory, $options);
		return $builder;
	}
	
	public function getParent() {

		return 'column';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {}
	
	public function getOptionsResolver() {

		return new OptionsResolver();
	}

}
