<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;

use Yjv\ReportRendering\Tests\Report\Extension\Core\Type\TypeTestCase;

use Mockery;

class RendererTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new RendererType();
    }
    
    public function testGetName()
    {
        $this->assertEquals('renderer', $this->type->getName());
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
    
    public function testBuildRenderer()
    {
        $options = array(
                'constructor' => function(){}
        );
        
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('setConstructor')
            ->once()
            ->with($options['constructor'])
            ->getMock()
        ;
        
        $this->type->buildRenderer($builder, $options);
    }
    
    public function testBuildRendererWithNoConstructor()
    {
        $options = array(
                'constructor' => null
        );
        
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
        ;
        
        $this->type->buildRenderer($builder, $options);
    }
    
    public function testCreateBuilder()
    {
        $options = array('key' => 'value');
        $this->assertEquals(new RendererBuilder($this->factory, $options), $this->type->createBuilder($this->factory, $options));
    }
}
