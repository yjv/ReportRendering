<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface ReportTypeInterface {

	public function getBuilder(array $options);
	public function setDefaultOptions(OptionsResolverInterface $optionsResolver);
	public function build(ReportBuilderInterface $reportBuilder, array $options);
	public function getName();
	public function getParent();
}
