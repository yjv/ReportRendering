<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report\Type;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Yjv\Bundle\ReportRenderingBundle\Report\ReportBuilder;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;
use Yjv\Bundle\ReportRenderingBundle\Report\ReportBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\Bundle\ReportRenderingBundle\Report\AbstractReportType;

class ReportType extends AbstractReportType
{
    /**
     * @param ReportBuilderInterface $reportBuilder
     * @param array $options
     */
    public function buildReport(ReportBuilderInterface $reportBuilder, array $options)
    {
        $reportBuilder->setDatasource($options['datasource']);

        if ($options['default_renderer']) {

            $reportBuilder->setDefaultRenderer($options['default_renderer']);
        }

        if ($options['filter_collection']) {

            $reportBuilder->setFilterCollection($options['filter_collection']);
        }
    }

    /**
     * @param OptionsResolverInterface $optionsResolver
     */
    public function setDefaultOptions(OptionsResolverInterface $optionsResolver)
    {

        $optionsResolver
            ->setDefaults(array(
                'datasource' => null, 
                'filter_collection' => null,
                'default_renderer' => function (Options $options)
                {
                    if (!empty($options['renderers'])) {

                        return reset($options['renderers']);
                    }

                    return null;
                }, 
                'renderers' => array()
            ))
            ->setAllowedTypes(array(
                'datasource' => 'Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface',
                'filter_collection' => array(
                    'Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface', 
                    'null'
                ),
                'default_renderer' => array(
                    'Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface',
                    'null'
                ), 
                'renderers' => 'array'
            ));
    }

    /**
     * 
     */
    public function getName()
    {
        return 'report';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return false;
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new ReportBuilder($factory, new EventDispatcher(), $options);
    }
}