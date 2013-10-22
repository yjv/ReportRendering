<?php
namespace Yjv\ReportRendering\Tests\Factory\Extension;

use Yjv\TypeFactory\Extension\DependencyInjectionExtension;

use Mockery;

class DependencyInjectionExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    protected $container;
    
    public function setUp()
    {
        $this->container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->extension = new DependencyInjectionExtension($this->container);
    }
    
    public function testAddType()
    {
        $this->assertSame($this->extension, $this->extension->addType('name', 'service'));
    }
    
    public function testAddTypeExtension()
    {
        $this->assertSame($this->extension, $this->extension->addTypeExtension('name', 'service'));
    }
    
    public function testHasType()
    {
        $this->assertFalse($this->extension->hasType('name'));
        $this->extension->addType('name', 'service');
        $this->assertTrue($this->extension->hasType('name'));
    }
    
    public function testHasTypeExtension()
    {
        $this->assertFalse($this->extension->hasTypeExtensions('name'));
        $this->extension->addTypeExtension('name', 'service');
        $this->assertTrue($this->extension->hasTypeExtensions('name'));
    }
    
    public function testGetType()
    {
        $type = Mockery::mock('Yjv\TypeFactory\TypeInterface');
        $this->container
            ->shouldReceive('get')
            ->with('service')
            ->once()
            ->andReturn($type)
        ;
        
        $this->extension->addType('name', 'service');
        $this->assertSame($type, $this->extension->getType('name'));
        $this->assertSame($type, $this->extension->getType('name'));
    }

    /**
     * @expectedException Yjv\TypeFactory\TypeNotFoundException
     * @expectedExceptionMessage type with name "name" not found
     */
    public function testGetTypeWhenNotSet()
    {
        $this->extension->getType('name');
    }
    
    public function testGetTypeExtensions()
    {
        $typeExtension1 = Mockery::mock('Yjv\TypeFactory\TypeExtensionInterface');
        $typeExtension2 = Mockery::mock('Yjv\TypeFactory\TypeExtensionInterface');
        $this->container
            ->shouldReceive('get')
            ->with('service1')
            ->once()
            ->andReturn($typeExtension1)
            ->getMock()
            ->shouldReceive('get')
            ->with('service2')
            ->once()
            ->andReturn($typeExtension2)
            ->getMock()
        ;
        
        $this->extension->addTypeExtension('name', 'service1');
        $this->extension->addTypeExtension('name', 'service2');
        $this->assertSame(array($typeExtension1, $typeExtension2), $this->extension->getTypeExtensions('name'));
        $this->assertSame(array($typeExtension1, $typeExtension2), $this->extension->getTypeExtensions('name'));
    }
    
    public function testGetTypeExtensionsWithNoneAdded()
    {
        $this->assertEquals(array(), $this->extension->getTypeExtensions('name'));
    }
}
