<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/8/14
 * Time: 10:06 PM
 */

namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Builder;

use Mockery;
use Yjv\ReportRendering\Datasource\ArrayDatasource;
use Yjv\ReportRendering\Datasource\Extension\Core\Builder\ArrayBuilder;
use Yjv\TypeFactory\Tests\AbstractBuilderTest;

/**
 * Class ArrayBuilderTest
 * @package Yjv\ReportRendering\Tests\Datasource\Extension\Core\Builder
 *
 * @property ArrayBuilder $builder
 */
class ArrayBuilderTest extends AbstractBuilderTest
{
    public function setUp()
    {
        parent::setUp();
        $this->builder = new ArrayBuilder($this->factory, $this->options);
    }

    public function testGettersSetters()
    {
        parent::testGettersSetters();
        $propertyAccessor = Mockery::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $this->assertInstanceOf('Symfony\Component\PropertyAccess\PropertyAccessorInterface', $this->builder->getPropertyAccessor());
        $this->assertSame($this->builder, $this->builder->setPropertyAccessor($propertyAccessor));
        $this->assertSame($propertyAccessor, $this->builder->getPropertyAccessor());
        $data = array('key' => 'value');
        $this->assertEquals(array(), $this->builder->getData());
        $this->assertSame($this->builder, $this->builder->setData($data));
        $this->assertEquals($data, $this->builder->getData());
        $this->assertEquals(array(), $this->builder->getFilterMap());
        $this->assertSame($this->builder, $this->builder->setFilterMap($filterMap = array('filter' => 'map')));
        $this->assertEquals($filterMap, $this->builder->getFilterMap());
    }

    public function testBuild()
    {
        $propertyAccessor = Mockery::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $data = array(array('data' => 'value'));
        $filterMap = array('filter' => 'map');
        $options = array(
            'filter_map' => $filterMap,
            'data' => $data,
            'property_accessor' => $propertyAccessor
        );
        $datasource = new ArrayDatasource($data, $propertyAccessor);
        $datasource->setFilterMap($filterMap);

        $this->builder
            ->setFilterMap($options['filter_map'])
            ->setPropertyAccessor($propertyAccessor)
            ->setData($data)
        ;

        $this->assertEquals($datasource, $this->builder->build());
    }
}