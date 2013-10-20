<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\DatasourceType;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Mockery;

class DatasourceTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new DatasourceType();
    }
    
    public function testGetName()
    {
        $this->assertEquals('datasource', $this->type->getName());
    }
    
    public function testGetParent()
    {
        $this->assertFalse($this->type->getParent());
    }
    
    public function testSetDefaultOptions()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->with(array('constructor' => null))
            ->andReturn(Mockery::self())
            ->once()
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array('constructor' => array('callable', 'null')))
            ->andReturn(Mockery::self())
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);
    }
    
    public function testBuildDatasource()
    {
        $options = array(
                'constructor' => function(){}
        );
        
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
            ->shouldReceive('setConstructor')
            ->once()
            ->with($options['constructor'])
            ->getMock()
        ;
        
        $this->type->buildDatasource($builder, $options);
    }
    
    public function testBuildRendererWithNoConstructor()
    {
        $options = array(
                'constructor' => null
        );
        
        $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
        ;
        
        $this->type->buildDatasource($builder, $options);
    }
    
    public function testCreateBuilder()
    {
        $options = array('key' => 'value');
        $this->assertEquals(new DatasourceBuilder($this->factory, $options), $this->type->createBuilder($this->factory, $options));
    }
}
