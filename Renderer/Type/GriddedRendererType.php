<?php
namespace Yjv\ReportRendering\Renderer\Type;

use Yjv\ReportRendering\Factory\TypeInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class GriddedRendererType extends AbstractRendererType
{
    public function buildRenderer(RendererBuilderInterface $builder, $options)
    {
        if ($options['grid'] instanceof GridInterface) {
            
            $grid = $options['grid'];
        }else{
            
            $grid = new Grid();
            
            $columnFactory = $builder->getFactory()->getColumnFactory();
            
            foreach ($options['columns'] as $columnInfo) {
                
                if ($columnInfo instanceof ColumnInterface) {
                    
                    $column = $columnInfo;
                }else{
                    
                    list($type, $options) = $this->getTypeAndOptions($columnInfo);
                    $column = $columnFactory->create($type, $options);
                }
            }
        }
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
    }
    
    public function getName()
    {
        return 'gridded_renderer';
    }
    
    protected function getTypeAndOptions($columnInfo){
        
        if($columnInfo instanceof TypeInterface || is_string($columnInfo)){
            
            return array($columnInfo, array());
        }
        
        if (!is_array($columnInfo)) {
            
            throw new RuntimeException('columns in the solumns option must be instances of ColumnInterface, TypeInterface, a string or an array containing at least the former and optionaly options');
        }
        
        if (count($columnInfo) == 1) {
            
            $columnInfo[1] = array();
        }
        
        return $columInfo;
    }
}
