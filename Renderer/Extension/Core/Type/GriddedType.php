<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

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
                
                if ($columnInfo instanceof ColumnInterface) {
                    
                    $column = $columnInfo;
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
        ;
        
        $columnsNormalizer = function(Options $options, $columns)
        {
            $newColumns = array();
            
            foreach ($columns as $column) {
               
                if($column instanceof TypeInterface || is_string($column)){
                    
                    $column = array($column, array());
                }
                
                if (!is_array($column)) {
                    
                    throw new \RuntimeException('columns in the solumns option must be instances of ColumnInterface, TypeInterface, a string or an array containing at least the former and optionaly options');
                }
                
                if (count($column) == 1) {
                    
                    $column[] = array();
                }
                
                $newColumns[] = $column;
            }

            return $newColumns;
        };
        
        $resolver->setNormalizers(array('columns' => $columnsNormalizer));
    }
    
    public function getName()
    {
        return 'gridded';
    }
}
