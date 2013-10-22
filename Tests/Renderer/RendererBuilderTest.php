<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Mockery;

class RendererBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $factory;
    
    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->builder = new RendererBuilder($this->factory);
    }
    
    public function testGettersSetters()
    {
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $this->assertSame($this->builder, $this->builder->setGrid($grid));
        $this->assertSame($grid, $this->builder->getGrid());
    }

    public function testGetRenderer()
    {
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        
        $callback = function() use ($renderer){
            
            return $renderer;
        };
        
        $this->builder->setConstructor($callback);
        $this->assertSame($renderer, $this->builder->getRenderer());
    }
    
    /**
     * @expectedException Yjv\ReportRendering\Renderer\ValidRendererNotReturnedException
     * @expectedExceptionMessage No valid renderer was returned from the builder's constructor callback.
     */
    public function testGetRendererWithInvalidRenderer()
    {
        $callback = function(){};
        $this->builder->setConstructor($callback);
        $this->builder->getRenderer();
    }
}
