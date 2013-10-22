<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Factory\VariableConstructorBuilder;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Mockery;

class VariableConstructorBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $factory;
    
    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->builder = new VariableConstructorBuilder($this->factory);
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
}
