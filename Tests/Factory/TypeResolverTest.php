<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Factory;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChain;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeResolver;

use Mockery;

class TypeResolverTest extends \PHPUnit_Framework_TestCase
{
    protected $resolver;
    protected $registry;
    
    public function setUp()
    {
        $this->registry = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistryInterface');
        $this->resolver = new TypeResolver($this->registry);
    }
    
    public function testResolveTypeChain()
    {
        $type1 = $this->getType('name1', null);
        $type2 = $this->getType('name2', $type1);
        $type3 = $this->getType('name3', 'name2');
        
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
        ;
        $this->assertEquals(
                new TypeChain(array($type1, $type2, $type3)), 
                $this->resolver->resolveTypeChain($type3)
        );
        $this->assertEquals(
                new TypeChain(array($type1, $type2, $type3)), 
                $this->resolver->resolveTypeChain('name3')
        );
    }
    
    public function testResolverType()
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
        return Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
            ->shouldReceive('getName')
            ->andReturn($name)
            ->getMock()
            ->shouldReceive('getParent')
            ->andReturn($parent)
            ->getMock()
        ;
    }
}
