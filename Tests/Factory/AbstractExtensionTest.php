<?php
namespace Yjv\ReportRendering\Tests\Factory;

use Yjv\ReportRendering\Factory\AbstractExtension;

use Mockery;

class AbstractExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    protected $type;
    protected $typeExtension;
    
    public function setUp()
    {
        $this->type = Mockery::mock('Yjv\ReportRendering\Factory\TypeInterface')
            ->shouldReceive('getName')
            ->andReturn('name')
            ->getMock()
        ;
        $this->typeExtension = Mockery::mock('Yjv\ReportRendering\Factory\TypeExtensionInterface')
            ->shouldReceive('getExtendedType')
            ->andReturn('name')
            ->getMock()
        ;
        $this->extension = new TestAbstractExtension(array($this->type), array($this->typeExtension));
    }
    
    public function testTypeGetters()
    {
        $this->assertTrue($this->extension->hasType('name'));
        $this->assertSame($this->type, $this->extension->getType('name'));
        $this->assertFalse($this->extension->hasType('name2'));
    }
    
    /**
     * @expectedException Yjv\ReportRendering\Factory\TypeNotFoundException
     * @expectedExceptionMessage type with name "name2" not found
     */
    public function testExceptionOnTypeNotFound()
    {
        $this->extension->getType('name2');
    }
    
    public function testTypeExtensionGetters()
    {
        $this->assertTrue($this->extension->hasTypeExtensions('name'));
        $this->assertSame(array($this->typeExtension), $this->extension->getTypeExtensions('name'));
        $this->assertFalse($this->extension->hasTypeExtensions('name2'));
        $this->assertEquals(array(), $this->extension->getTypeExtensions('name2'));
    }
}

class TestAbstractExtension extends AbstractExtension
{
    protected $constructorTypes;
    protected $constructorTypeExtensions;
    
    public function __construct(array $types, array $typeExtensions){
        
        $this->constructorTypes = $types;
        $this->constructorTypeExtensions = $typeExtensions;
    }
    
    public function loadTypes()
    {
        return $this->constructorTypes;
    }
    
    public function loadTypeExtensions()
    {
        return $this->constructorTypeExtensions;
    }
}
