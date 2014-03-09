<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\Extension\Core\Builder\CallbackBuilder;
use Yjv\ReportRendering\Datasource\Extension\Core\Type\CallbackType;
use Mockery;

/**
 * Class CallbackTypeTest
 * @package Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type
 *
 * @property CallbackType $type
 */
class CallbackTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new CallbackType();
    }
    
    public function testGetName()
    {
        $this->assertEquals('callback', $this->type->getName());
    }
    
    public function testSetDefaultOptions()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('callback'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->with(array(
                'params' => array()
            ))
            ->andReturn(Mockery::self())
            ->once()
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array(
                'callback' => 'callable',
                'params' => 'array'
            ))
            ->andReturn(Mockery::self())
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);
    }

    public function testBuildDatasource()
    {
        $this->type = new CallbackType();

        $options = array(
            'callback' => $params = array($this, 'testBuildRendererWithEverythingEmpty'),
            'params' => $params = array('value1', 'value2'),
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('setCallback')
            ->once()
            ->with($options['callback'])
            ->getMock()
            ->shouldReceive('setParams')
            ->once()
            ->with($options['params'])
            ->getMock()
        ;
        $this->type->buildDatasource($builder, $options);
    }

    public function testCreateBuilder()
    {
        $factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $options = array('key' =>' value');
        $this->assertEquals(new CallbackBuilder($factory, $options), $this->type->createBuilder($factory, $options));
    }
}
