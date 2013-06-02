<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilder;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\AbstractColumnType;

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

    public function buildColumn(ColumnBuilderInterface $builder, array $options)
    {
        $builder->setOptions(array(
            'name' => $options['name'],
            'sortable' => $options['sortable'],
            'escape_output' => $options['escape_output']
        ));

        $builder->setCellOptions(array('escape_output' => $options['escape_output']));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array('escape_output' => true, 'sortable' => true, 'name' => ''))
            ->setAllowedTypes(array('escape_output' => 'bool', 'sortable' => 'bool', 'name' => 'string'))
        ;
    }
    
    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        $builder = new ColumnBuilder($factory, $options);
        return $builder;
    }
}
