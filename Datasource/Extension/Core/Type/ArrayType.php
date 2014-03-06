<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\ArrayDatasource;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;

use Yjv\ReportRendering\Datasource\AbstractDatasourceType;
use Yjv\ReportRendering\Datasource\Extension\Core\Builder\ArrayBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;

class ArrayType extends AbstractDatasourceType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('data'))
            ->setDefaults(array(
                'constructor' => function(DatasourceBuilderInterface $builder)
                {
                    $datasource = new ArrayDatasource(
                        $builder->getOption('data'), 
                        $builder->getOption('property_accessor')
                    );
                    $datasource->setFilterMap($builder->getOption('filter_map', array()));
                    return $datasource;
                },
                'property_accessor' => null,
                'filter_map' => array()
            ))
            ->setAllowedTypes(array(
                'data' => array('array', 'Traversable'),
                'property_accessor' => array('null', 'Symfony\Component\PropertyAccess\PropertyAccessorInterface'),
                'filter_map' => 'array'
            ))
        ;
    }
    
    public function getName()
    {
        return 'array';
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new ArrayBuilder($factory, $options);
    }

}
