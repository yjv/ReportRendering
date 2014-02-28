<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\CallbackDatasource;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\CallbackType;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;

use Mockery;

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
        $testCase = $this;
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('callback'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->with(Mockery::on(function($value) use ($testCase){
                
                $testCase->assertEquals(array(
                        'constructor' => function(DatasourceBuilderInterface $builder)
                        {
                            return new CallbackDatasource(
                                    $builder->getOption('callback'),
                                    $builder->getOption('params')
                            );
                        },
                        'params' => array()
                ), $value);
                
                return true;
            }))
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
    
    public function testConstructor()
    {
        $resolver = new OptionsResolver();
        $this->type->setDefaultOptions($resolver);
        $callback = function(){};
        $params = array('key' => 'value');
        $options = $resolver->resolve(array('callback' => function(){}));
        $datasource = new CallbackDatasource($callback, $params);
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('getOption')
            ->once()
            ->with('callback')
            ->andReturn($callback)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('params')
            ->andReturn($params)
            ->getMock()
        ;
        
        $this->assertEquals($datasource, $options['constructor']($builder));
    }
}
