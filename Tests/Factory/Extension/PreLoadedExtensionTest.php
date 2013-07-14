<?php
namespace Yjv\ReportRendering\Tests\Factory\Extension;

use Yjv\ReportRendering\Factory\Extension\PreloadedExtension;

use Mockery;

class PreLoadedExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    protected $type1;
    protected $type2;
    protected $typeExtension1;
    protected $typeExtension2;
    
    public function setUp()
    {
        $this->type1 = Mockery::mock('Yjv\ReportRendering\Factory\TypeInterface')
            ->shouldReceive('getName')
            ->once()
            ->andReturn('type1')
            ->getMock()
        ;
        $this->type2 = Mockery::mock('Yjv\ReportRendering\Factory\TypeInterface')
            ->shouldReceive('getName')
            ->once()
            ->andReturn('type2')
            ->getMock()
        ;
        $this->typeExtension1 = Mockery::mock('Yjv\ReportRendering\Factory\TypeExtensionInterface')
            ->shouldReceive('getExtendedType')
            ->once()
            ->andReturn('type1')
            ->getMock()
        ;
        $this->typeExtension2 = Mockery::mock('Yjv\ReportRendering\Factory\TypeExtensionInterface')
            ->shouldReceive('getExtendedType')
            ->once()
            ->andReturn('type2')
            ->getMock()
        ;
        
        $this->extension = new PreloadedExtension(array(
            $this->type1,
            $this->type2,
        ), array(
            $this->typeExtension1,
            $this->typeExtension2,
        ));
    }
    
    public function testGettersAndIssers()
    {
        $this->assertTrue($this->extension->hasType('type1'));
        $this->assertSame($this->type1, $this->extension->getType('type1'));
        $this->assertTrue($this->extension->hasType('type2'));
        $this->assertSame($this->type2, $this->extension->getType('type2'));
        $this->assertTrue($this->extension->hasTypeExtensions('type1'));
        $this->assertSame(array($this->typeExtension1), $this->extension->getTypeExtensions('type1'));
        $this->assertTrue($this->extension->hasTypeExtensions('type2'));
        $this->assertSame(array($this->typeExtension2), $this->extension->getTypeExtensions('type2'));
    }
}
