<?php
namespace Yjv\ReportRendering\Report\Extension\Core\Type;

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
        $reportBuilder->setDatasource($options['datasource']);

        if ($options['default_renderer']) {

            $reportBuilder->setDefaultRenderer($options['default_renderer']);
        }

        if ($options['filter_collection']) {

            $reportBuilder->setFilterCollection($options['filter_collection']);
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
                'filter_collection' => null,
                'default_renderer' => 'default', 
                'renderers' => array()
            ))
            ->setAllowedTypes(array(
                'datasource' => 'Yjv\ReportRendering\Datasource\DatasourceInterface',
                'filter_collection' => array(
                    'Yjv\ReportRendering\Filter\FilterCollectionInterface', 
                    'null'
                ),
                'default_renderer' => array('string'), 
                'renderers' => 'array'
            ));
            
            $renderersNormalizer = function(Options $options, $renderers)
            {
                $newRenderers = array();
            
                foreach ($renderers as $name => $renderer) {
                     
                    if(!is_array($renderer)){
                    
                        $renderer = array($renderer, array());
                    }
                    
                    if (count($renderer) == 1) {
                    
                        $renderer[] = array();
                    }
                    
                    $newRenderers[$name] = $renderer;
                }
            
                return $newRenderers;
            };
            
            $resolver->setNormalizers(array(
                'renderers' => $renderersNormalizer,
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