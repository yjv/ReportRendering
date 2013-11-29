<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Symfony\Component\OptionsResolver\Options;

use Yjv\ReportRendering\DataTransformer\EscapePathsTransformer;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface;
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
