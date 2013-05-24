<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractType;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\FinalizingTypeInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

abstract class AbstractReportType extends AbstractType implements FinalizingTypeInterface
{
    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $optionsResolver)
    {
    }

    final public function build($builder, array $options)
    {
        return $this->buildReport($builder, $options);
    }

    public function buildReport(ReportBuilderInterface $reportBuilder, array $options)
    {
    }

    /**
     * @param unknown $object
     * @param array $options
     */
    final public function finalize($object, array $options)
    {
        $this->finalizeReport($object, $options);
    }

    public function finalizeReport(ReportInterface $report, array $options)
    {
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return 'report';
    }
}
