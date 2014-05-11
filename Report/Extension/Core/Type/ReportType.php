<?php
namespace Yjv\ReportRendering\Report\Extension\Core\Type;


use Yjv\ReportRendering\EventListener\LazyLoadedRendererManagementSubscriber;
use Yjv\ReportRendering\EventListener\RenderFilterManagementSubscriber;
use Yjv\ReportRendering\Filter\DefaultedFilterCollectionInterface;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\Util\Factory;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Yjv\ReportRendering\Report\ReportBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;
use Yjv\ReportRendering\Report\ReportBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Report\AbstractReportType;

class ReportType extends AbstractReportType
{
    /**
     * @param ReportBuilderInterface $reportBuilder
     * @param array $options
     */
    public function buildReport(ReportBuilderInterface $reportBuilder, array $options)
    {
        $reportBuilder->setDefaultRenderer($options['default_renderer']);

        if ($options['datasource'][0]) {

            $datasource = $options['datasource'];
            $reportBuilder->setDatasource($datasource[0], $datasource[1]);
        }

        if ($options['filters']) {

            $reportBuilder->setFilters($options['filters']);
        }
        
        foreach ($options['renderers'] as $name => $renderer) {
            
            $reportBuilder->addRenderer($name, $renderer[0], $renderer[1]);
        }
    }

    /**
     * @param OptionsResolverInterface $optionsResolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver
            ->setDefaults(array(
                'datasource' => null, 
                'filters' => null,
                'default_renderer' => 'default', 
                'renderers' => array(),
                'filter_defaults' => array()
            ))
            ->setAllowedTypes(array(
                'datasource' => array(
                    'Yjv\ReportRendering\Datasource\DatasourceInterface', 
                    'null',
                    'array'
                ),
                'filters' => array(
                    'Yjv\ReportRendering\Filter\FilterCollectionInterface', 
                    'null'
                ),
                'default_renderer' => array('string'), 
                'renderers' => 'array',
                'filter_defaults' => 'array'
            ))
            ->setNormalizers(array(
                'datasource' => function(Options $options, $datasource)
                {
                    return Factory::normalizeToFactoryArguments($datasource);
                },
                'renderers' => function(Options $options, $renderers)
                {
                    return Factory::normalizeCollectionToFactoryArguments($renderers);
                },
                'default_renderer' => function(Options $options, $defaultRenderer)
                {
                    return (string)$defaultRenderer;
                }
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
        return new ReportBuilder($options['name'], $factory, new EventDispatcher(), $options);
    }

    /**
     * @param ReportInterface $report
     * @param array $options
     */
    public function finalizeReport(ReportInterface $report, array $options)
    {
        if ($report->getFilters() instanceof DefaultedFilterCollectionInterface) {

            $report->getFilters()->setDefaults($options['filter_defaults']);
        }

        $report->addEventSubscriber(new RenderFilterManagementSubscriber());
        $report->addEventSubscriber(new LazyLoadedRendererManagementSubscriber());
    }
}