<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;



use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

use Yjv\TypeFactory\TypeFactoryInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType;

class ColumnType extends AbstractColumnType
{
    public function getParent()
    {
        return false;
    }

    public function getName()
    {
        return 'column';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'sortable' => true, 
                'name' => ''
            ))
            ->setAllowedTypes(array(
                'sortable' => 'bool', 
                'name' => 'string'
            ))
        ;
    }
    
    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        $builder = new ColumnBuilder($factory, $options);
        return $builder;
    }
}
