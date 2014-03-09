<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;
use Yjv\ReportRendering\Datasource\AbstractDatasourceType;
use Yjv\ReportRendering\Datasource\Extension\Core\Builder\ArrayBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;

class ArrayType extends AbstractDatasourceType
{
    /**
     * @param DatasourceBuilderInterface|ArrayBuilder $builder
     * @param array $options
     */
    public function buildDatasource(DatasourceBuilderInterface $builder, array $options)
    {
        $builder->setFilterMap($options['filter_map']);
        $builder->setData($options['data']);

        if ($options['property_accessor']) {

            $builder->setPropertyAccessor($options['property_accessor']);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('data'))
            ->setDefaults(array(
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
