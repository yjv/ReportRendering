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
        $this->factory = Mockery::mock('Yjv\ReportRendering\Factory\TypeFactoryInterface');
        $this->builder = new RendererBuilder($this->factory);
    }
    
    public function testGettersSetters()
    {
        $this->assertNull($this->builder->getConstructor());
        $callback = function(){};
        $this->assertSame($this->builder, $this->builder->setConstructor($callback));
        $this->assertSame($callback, $this->builder->getConstructor());
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage $callback must a valid callable.
     */
    public function testSetConstructorWithInvalidCallback()
    {
        $this->builder->setConstructor('hello');
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
