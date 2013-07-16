<?php
namespace Yjv\ReportRendering\Report\Extension\Core\Type;

use Yjv\ReportRendering\Util\Factory;

use Yjv\ReportRendering\IdGenerator\ConstantValueIdGenerator;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Yjv\ReportRendering\Report\ReportBuilder;
use Yjv\ReportRendering\Factory\TypeFactoryInterface;
use Yjv\ReportRendering\Filter\NullFilterCollection;
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

        if ($options['datasource']) {

            $reportBuilder->setDatasource($options['datasource']);
        }

        if ($options['filters']) {

            $reportBuilder->setFilters($options['filters']);
        }
        
        foreach ($options['renderers'] as $name => $renderer) {
            
            $reportBuilder->addRenderer($name, $renderer[0], $renderer[1]);
        }

        if ($options['id_generator']) {
            
            $reportBuilder->setIdGenerator($options['id_generator']);
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
                'id_generator' => function (Options $options)
                {
                    if (!is_null($options['id'])) {
                        
                        return new ConstantValueIdGenerator($options['id']);
                    }
                    
                    return null;
                },
                'id' => null
            ))
            ->setAllowedTypes(array(
                'datasource' => array(
                    'Yjv\ReportRendering\Datasource\DatasourceInterface', 
                    'null'
                ),
                'filters' => array(
                    'Yjv\ReportRendering\Filter\FilterCollectionInterface', 
                    'null'
                ),
                'default_renderer' => array('string'), 
                'renderers' => 'array',
                'id_generator' => array(
                    'null', 
                    'Yjv\ReportRendering\IdGenerator\IdGeneratorInterface'
                )
            ))
            ->setNormalizers(array(
                'renderers' => function(Options $options, $renderers)
                {
                    return Factory::normalizeOptionsCollectionToFactoryArguments($options, $renderers);
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
        return new ReportBuilder($factory, new EventDispatcher(), $options);
    }
}