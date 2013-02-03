<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeInterface {

	public function build($builder, array $options);
	public function createBuilder(TypeFactoryInterface $factory, array $options);
	public function getName();
	public function getParent();
	public function setDefaultOptions(OptionsResolverInterface $resolver);
	public function getOptionsResolver();
}
