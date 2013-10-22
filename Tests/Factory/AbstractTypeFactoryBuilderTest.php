<?php
namespace Yjv\ReportRendering\Tests\Factory;
use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\TypeFactory\TypeRegistryInterface;

use Yjv\TypeFactory\AbstractTypeFactory;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\TypeRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Mockery;

class TypeFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('Yjv\TypeFactory\AbstractTypeFactoryBuilder');
    }
    
    public function testAddExtension()
    {
        $extension1 = Mockery::mock('Yjv\TypeFactory\RegistryExtensionInterface');
        $extension2 = Mockery::mock('Yjv\TypeFactory\RegistryExtensionInterface');
        $registry = Mockery::mock('Yjv\TypeFactory\TypeRegistryInterface')
            ->shouldReceive('addExtension')
            ->once()
            ->with($extension1)
            ->getMock()
            ->shouldReceive('addExtension')
            ->once()
            ->with($extension2)
            ->getMock()
        ;
        $factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface')
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
        $this->assertInstanceOf('Yjv\TypeFactory\TypeRegistryInterface', $this->builder->getTypeRegistry());
        $registry = Mockery::mock('Yjv\TypeFactory\TypeRegistryInterface');
        $this->assertSame($this->builder, $this->builder->setTypeRegistry($registry));
        $this->assertSame($registry, $this->builder->getTypeRegistry());
        $this->assertInstanceOf('Yjv\TypeFactory\TypeResolverInterface', $this->builder->getTypeResolver());
        $resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface');
        $this->assertSame($this->builder, $this->builder->setTypeResolver($resolver));
        $this->assertSame($resolver, $this->builder->getTypeResolver());
        $this->assertNull($this->builder->getTypeName());
        $name = 'name';
        $this->assertSame($this->builder, $this->builder->setTypeName($name));
        $this->assertEquals($name, $this->builder->getTypeName());
        $this->assertInstanceOf(get_class($this->builder), call_user_func(array(get_class($this->builder), 'getInstance')));
    }
}
