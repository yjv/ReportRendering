<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\ArrayDatasource;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\ArrayType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Mockery;

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
        $testCase = $this;
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('data'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->with(Mockery::on(function($value) use ($testCase){
                
                $testCase->assertEquals(array(
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
                ), $value);
                
                return true;
            }))
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
    
    public function testConstructor()
    {
        $resolver = new OptionsResolver();
        $this->type->setDefaultOptions($resolver);
        $data = array(array('data' => 'value'));
        $propertyAccessor = Mockery::mock('Symfony\Component\PropertyAccess\PropertyAccessorInterface');
        $filterMap = array('filter' => 'map');
        $options = $resolver->resolve(array('data' => $data));
        $datasource = new ArrayDatasource($data, $propertyAccessor);
        $datasource->setFilterMap($filterMap);
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('getOption')
            ->once()
            ->with('data')
            ->andReturn($data)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('property_accessor')
            ->andReturn($propertyAccessor)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('filter_map', array())
            ->andReturn($filterMap)
            ->getMock()
        ;
        
        $this->assertEquals($datasource, $options['constructor']($builder));
    }
}
