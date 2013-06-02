<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChainInterface;

use Mockery;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChain;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

class TypeChainTest extends \PHPUnit_Framework_TestCase{

	protected $chain;
	protected $types;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->types = array('hello', 'goodbye', 'seeya');
		$this->chain = new TypeChain($this->types);
	}
	
	public function testIteration() {
		
		$this->assertSame($this->types, iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
		$this->assertSame(array_reverse($this->types, true), iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
		$this->assertSame($this->types, iterator_to_array($this->chain));
	}
	
	public function testGetOptionsResolver()
	{
	    $optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
	    $type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('getOptionsResolver')
	        ->ordered()
	        ->once()
	        ->getMock()
	    ;
	    $type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('getOptionsResolver')
	        ->ordered()
	        ->once()
	        ->andReturn($optionsResolver)
	        ->getMock()
	    ;
	    $type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface');
	    $typeChain = new TypeChain(array($type1, $type2, $type3));
	    $this->assertSame($optionsResolver, $typeChain->getOptionsResolver());
	}
	
	public function testGetOptions()
	{
	    $options = array('key' => 'value');
	    $returnedOptions = array('key2' => 'value2', 'key' => 'value');
	    $optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
	    $type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $optionsResolver
	        ->shouldReceive('resolve')
	        ->with($options)
	        ->once()
	        ->ordered()
	        ->andReturn($returnedOptions)
	    ;
	    
	    $typeChain = new TypeChain(array($type1, $type2, $type3));
	    $this->assertEquals($returnedOptions, $typeChain->getOptions($optionsResolver, $options));
	}
	
	public function testGetBuilder()
	{
	    $builder = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface');
	    $options = array('key' => 'value');
	    $factory = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface');
	    $type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('createBuilder')
	        ->with($factory, $options)
	        ->ordered()
	        ->once()
	        ->getMock()
	    ;
	    $type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('createBuilder')
	        ->with($factory, $options)
	        ->ordered()
	        ->once()
	        ->andReturn($builder)
	        ->getMock()
	    ;
	    $type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface');
	    $typeChain = new TypeChain(array($type1, $type2, $type3));
	    $this->assertSame($builder, $typeChain->getBuilder($factory, $options));
	}
	
	public function testBuild()
	{
	    $options = array('key' => 'value');
	    $builder = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface');
	    $type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    $type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    $type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    
	    $typeChain = new TypeChain(array($type1, $type2, $type3));
	    $typeChain->build($builder, $options);
	}
	
	public function testFinalize()
	{
	    $options = array('key' => 'value');
	    $object = new \stdClass();
	    $type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\FinalizingTypeInterface')
	        ->shouldReceive('finalize')
	        ->ordered()
	        ->with($object, $options)
	        ->once()
	        ->getMock()
	    ;
	    $type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\FinalizingTypeInterface')
	        ->shouldReceive('finalize')
	        ->ordered()
	        ->with($object, $options)
	        ->once()
	        ->getMock()
	    ;
	    $type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface');
	    
	    $typeChain = new TypeChain(array($type1, $type2, $type3));
	    $typeChain->finalize($object, $options);
	}
}
