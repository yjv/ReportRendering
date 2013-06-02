<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Factory;

use Yjv\Bundle\ReportRenderingBundle\Factory\Builder;

use Mockery;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $factory;
    protected $options;
    
    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface');
        $this->options = array('key' => 'value');
        $this->builder = new Builder($this->factory, $this->options);
    }
    
    public function testGettersSetters()
    {
        $this->assertEquals($this->options, $this->builder->getOptions());
        $this->assertSame($this->builder, $this->builder->setOption('key2', 'value2'));
        $this->assertEquals(array('key' => 'value', 'key2' => 'value2'), $this->builder->getOptions());
        $this->assertEquals('value2', $this->builder->getOption('key2'));
        $this->assertNull($this->builder->getOption('key3'));
        $this->assertEquals('default', $this->builder->getOption('key3', 'default'));
        $this->assertSame($this->builder, $this->builder->setOptions(array('key3' => 'value3')));
        $this->assertEquals(array('key3' => 'value3'), $this->builder->getOptions());
        $this->assertSame($this->factory, $this->builder->getFactory());
        $typeChain = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeChainInterface');
        $this->assertNull($this->builder->getTypeChain());
        $this->assertSame($this->builder, $this->builder->setTypeChain($typeChain));
        $this->assertSame($typeChain, $this->builder->getTypeChain());
    }
}
