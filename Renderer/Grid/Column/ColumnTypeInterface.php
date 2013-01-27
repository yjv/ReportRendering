<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface ColumnTypeInterface {

	public function buildColumn(ColumnInterface $column, array $options);
	public function createColumn(array $options = array());
	public function getName();
	public function getParent();
	public function setDefaultOptions(OptionsResolverInterface $resolver);
	public function getOptionsResolver();
}
