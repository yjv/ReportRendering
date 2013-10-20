<?php
namespace Yjv\ReportRendering\Tests\Factory;
use Yjv\ReportRendering\Factory\AbstractTypeFactoryBuilder;

use Yjv\ReportRendering\Factory\TypeResolverInterface;

use Yjv\ReportRendering\Factory\TypeRegistryInterface;

use Yjv\ReportRendering\Factory\AbstractTypeFactory;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Yjv\ReportRendering\Factory\TypeRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Mockery;

class TypeFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('Yjv\ReportRendering\Factory\AbstractTypeFactoryBuilder');
    }
    
    public function testAddExtension()
    {
        $extension1 = Mockery::mock('Yjv\ReportRendering\Factory\RegistryExtensionInterface');
        $extension2 = Mockery::mock('Yjv\ReportRendering\Factory\RegistryExtensionInterface');
        $registry = Mockery::mock('Yjv\ReportRendering\Factory\TypeRegistryInterface')
            ->shouldReceive('addExtension')
            ->once()
            ->with($extension1)
            ->getMock()
            ->shouldReceive('addExtension')
            ->once()
            ->with($extension2)
            ->getMock()
        ;
        $factory = Mockery::mock('Yjv\ReportRendering\Factory\TypeFactoryInterface')
            ->shouldReceive('getTypeRegistry')
            ->once()
            ->andReturn($registry)
            ->getMock()
        ;
        $this->builder
            ->expects($this->once())
            ->method('getFactoryInstance')
            ->will($this->returnValue($factory))
        ;
        
        $this->builder->addExtension($extension1);
        $this->builder->addExtension($extension2);
        $this->assertSame($factory, $this->builder->build());
    }
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Factory\TypeRegistryInterface', $this->builder->getTypeRegistry());
        $registry = Mockery::mock('Yjv\ReportRendering\Factory\TypeRegistryInterface');
        $this->assertSame($this->builder, $this->builder->setTypeRegistry($registry));
        $this->assertSame($registry, $this->builder->getTypeRegistry());
        $this->assertInstanceOf('Yjv\ReportRendering\Factory\TypeResolverInterface', $this->builder->getTypeResolver());
        $resolver = Mockery::mock('Yjv\ReportRendering\Factory\TypeResolverInterface');
        $this->assertSame($this->builder, $this->builder->setTypeResolver($resolver));
        $this->assertSame($resolver, $this->builder->getTypeResolver());
        $this->assertNull($this->builder->getTypeName());
        $name = 'name';
        $this->assertSame($this->builder, $this->builder->setTypeName($name));
        $this->assertEquals($name, $this->builder->getTypeName());
        $this->assertInstanceOf(get_class($this->builder), call_user_func(array(get_class($this->builder), 'getInstance')));
    }
}
