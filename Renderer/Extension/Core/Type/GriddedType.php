<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Util\Factory;

use Yjv\ReportRendering\Factory\TypeInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

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
            
            $grid = $options['grid'];
        }else{
            
            $grid = new Grid();
            
            $columnFactory = $builder->getFactory()->getColumnFactory();
            
            foreach ($options['columns'] as $columnInfo) {
                
                if ($columnInfo[0] instanceof ColumnInterface) {
                    
                    $column = $columnInfo[0];
                } else {
                    
                    $column = $columnFactory->create($columnInfo[0], $columnInfo[1]);
                }
                
                $grid->addColumn($column);
            }
        }
        
        $builder->setGrid($grid);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                
            'columns' => array(),
            'grid' => null
        ))
        ->setAllowedTypes(array(
                'columns' => array('array', 'Travsersable'), 
                'grid' => array('null', 'Yjv\ReportRendering\Renderer\Grid\GridInterface')
        ))
        ->setNormalizers(array(
            'columns' => function(Options $options, $columns)
            {
                return Factory::normalizeOptionsCollectionToFactoryArguments($options, $columns);
            }
        ));
    }
    
    public function getName()
    {
        return 'gridded';
    }
}
