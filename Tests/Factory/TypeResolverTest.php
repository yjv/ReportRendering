<?php
namespace Yjv\ReportRendering\Tests\Factory;

use Yjv\ReportRendering\Factory\TypeChain;

use Yjv\ReportRendering\Factory\TypeResolver;

use Mockery;

class TypeResolverTest extends \PHPUnit_Framework_TestCase
{
    protected $resolver;
    protected $registry;
    
    public function setUp()
    {
        $this->registry = Mockery::mock('Yjv\ReportRendering\Factory\TypeRegistryInterface');
        $this->resolver = new TypeResolver($this->registry);
    }
    
    public function testResolveTypeChain()
    {
        $type1 = $this->getType('name1', null);
        $type2 = $this->getType('name2', $type1);
        $type3 = $this->getType('name3', 'name2');
        $type1Extension1 = $this->getTypeExtension('name1');
        $type1Extension2 = $this->getTypeExtension('name1');
        $type3Extension1 = $this->getTypeExtension('name3');
        
        $this->registry
            ->shouldReceive('getType')
            ->twice()
            ->with('name2')
            ->andReturn($type2)
            ->getMock()
            ->shouldReceive('getType')
            ->once()
            ->with('name3')
            ->andReturn($type3)
            ->getMock()
            ->shouldReceive('getTypeExtensions')
            ->with('name1')
            ->twice()
            ->andReturn(array($type1Extension1, $type1Extension2))
            ->getMock()
            ->shouldReceive('getTypeExtensions')
            ->with('name2')
            ->twice()
            ->andReturn(array())
            ->getMock()
            ->shouldReceive('getTypeExtensions')
            ->with('name3')
            ->twice()
            ->andReturn(array($type3Extension1))
        ;
        $typeChain = $this->resolver->resolveTypeChain($type3);
        $this->assertInstanceOf('Yjv\ReportRendering\Factory\TypeChainInterface', $typeChain);
        $this->assertSame(
            array($type1, $type1Extension1, $type1Extension2, $type2, $type3, $type3Extension1), 
            iterator_to_array($typeChain)
        );
        $typeChain = $this->resolver->resolveTypeChain('name3');
        $this->assertInstanceOf('Yjv\ReportRendering\Factory\TypeChainInterface', $typeChain);
        $this->assertSame(
            array($type1, $type1Extension1, $type1Extension2, $type2, $type3, $type3Extension1), 
            iterator_to_array($typeChain)
        );
    }
    
    public function testResolveType()
    {
        $type1 = $this->getType('name1', null);
        $this->registry
            ->shouldReceive('getType')
            ->once()
            ->with('name1')
            ->andReturn($type1)
            ->getMock()
        ;
        $this->assertSame($type1, $this->resolver->resolveType($type1));
        $this->assertSame($type1, $this->resolver->resolveType('name1'));
    }
    
    public function testGetTypeRegistry()
    {
        $this->assertSame($this->registry, $this->resolver->getTypeRegistry());
    }
    
    protected function getType($name, $parent)
    {
        return Mockery::mock('Yjv\ReportRendering\Factory\TypeInterface')
            ->shouldReceive('getName')
            ->andReturn($name)
            ->getMock()
            ->shouldReceive('getParent')
            ->andReturn($parent)
            ->getMock()
        ;
    }
	
	protected function getTypeExtension($name)
	{
	    return Mockery::mock('Yjv\ReportRendering\Factory\TypeExtensionInterface')
	        ->shouldReceive('getExtendedType')
	        ->andReturn($name)
	        ->getMock()
	    ;
	}
}
