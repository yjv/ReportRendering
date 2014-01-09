<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Util\Factory;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class GriddedType extends AbstractRendererType
{
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
        if ($options['grid'] instanceof GridInterface) {
            
            $builder->setGrid($options['grid']);
        }
            
        foreach ($options['columns'] as $column) {
            
            $builder->addColumn($column[0], $column[1]);
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                
            'columns' => array(),
            'grid' => null
        ))
        ->setAllowedTypes(array(
            'columns' => 'array', 
            'grid' => array('null', 'Yjv\ReportRendering\Renderer\Grid\GridInterface')
        ))
        ->setNormalizers(array(
            'columns' => function(Options $options, $columns)
            {
                return Factory::normalizeCollectionToFactoryArguments($columns);
            }
        ));
    }
    
    public function getName()
    {
        return 'gridded';
    }
}
