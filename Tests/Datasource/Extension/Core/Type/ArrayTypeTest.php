<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\Extension\Core\Builder\ArrayBuilder;
use Yjv\ReportRendering\Datasource\Extension\Core\Type\ArrayType;
use Mockery;

/**
 * Class ArrayTypeTest
 * @package Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type
 *
 * @property ArrayType $type
 */
class ArrayTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new ArrayType();
    }

    public function testGetName()
    {
        $this->assertEquals('array', $this->type->getName());
    }
    
    public function testSetDefaultOptions()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('data'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->with(array(
                'property_accessor' => null,
                'filter_map' => array()
            ))
            ->andReturn(Mockery::self())
            ->once()
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array(
                'data' => array('array', 'Traversable'),
                'property_accessor' => array('null', 'Symfony\Component\PropertyAccess\PropertyAccessorInterface'),
                'filter_map' => 'array'
            ))
            ->andReturn(Mockery::self())
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);
    }

    public function testCreateBuilder()
    {
        $factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $options = array('key' =>' value');
        $this->assertEquals(new ArrayBuilder($factory, $options), $this->type->createBuilder($factory, $options));
    }

    public function testBuildDatasourceWithNoPropertyAccessor()
    {
        $this->type = new ArrayType();

        $options = array(
            'filter_map' => $params = array($this, 'testBuildRendererWithEverythingEmpty'),
            'data' => $params = array('value1', 'value2'),
            'property_accessor' => null
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('setFilterMap')
            ->once()
            ->with($options['filter_map'])
            ->getMock()
            ->shouldReceive('setData')
            ->once()
            ->with($options['data'])
            ->getMock()
        ;
        $this->type->buildDatasource($builder, $options);
    }

    public function testBuildDatasourceWithPropertyAccessor()
    {
        $this->type = new ArrayType();

        $options = array(
            'filter_map' => $params = array($this, 'testBuildRendererWithEverythingEmpty'),
            'data' => $params = array('value1', 'value2'),
            'property_accessor' => Mockery::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface')
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('setFilterMap')
            ->once()
            ->with($options['filter_map'])
            ->getMock()
            ->shouldReceive('setData')
            ->once()
            ->with($options['data'])
            ->getMock()
            ->shouldReceive('setPropertyAccessor')
            ->once()
            ->with($options['property_accessor'])
            ->getMock()
        ;
        $this->type->buildDatasource($builder, $options);
    }

}
