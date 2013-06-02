<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChainInterface;

use Mockery;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChain;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

class TypeChainTest extends \PHPUnit_Framework_TestCase{

	protected $chain;
	protected $type1;
	protected $type2;
	protected $type2Extension;
	protected $type3;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->type1 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\FinalizingTypeInterface');
		$this->type2 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\FinalizingTypeInterface');
		$this->type2Extension = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeExtensionInterface');
		$this->type3 = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface');
		$this->types = array(
	        $this->type1,
	        $this->type2,
	        $this->type2Extension,
	        $this->type3
        );
	    $this->chain = new TypeChain($this->types);
	}
	
	public function testIteration() {
		
		$this->assertSame($this->types, iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_CHILD_FIRST);
		$this->assertSame(array_reverse($this->types, true), iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST);
		$this->assertSame($this->types, iterator_to_array($this->chain));
		$this->chain->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPE_EXTENSIONS);
		$this->assertSame(array($this->type1, $this->type2, $this->type3), array_values(iterator_to_array($this->chain)));
		$this->chain->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPES);
		$this->assertSame(array($this->type2Extension), array_values(iterator_to_array($this->chain)));
	}
	
	public function testEmptyArrayReturnedWhenAllExcluded()
	{
		$typeChain = new TypeChain(array($this->type1));
		$typeChain->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPES);
		$this->assertSame(array(), array_values(iterator_to_array($typeChain)));
	}
	
	public function testGetOptionsResolver()
	{
	    $optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
	    $this->type3
	        ->shouldReceive('getOptionsResolver')
	        ->ordered()
	        ->once()
	        ->getMock()
	    ;
	    $this->type2
	        ->shouldReceive('getOptionsResolver')
	        ->ordered()
	        ->once()
	        ->andReturn($optionsResolver)
	        ->getMock()
	    ;
	    $this->assertSame($optionsResolver, $this->chain->getOptionsResolver());
	}
	
	public function testGetOptions()
	{
	    $options = array('key' => 'value');
	    $returnedOptions = array('key2' => 'value2', 'key' => 'value');
	    $optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
	    $this->type1
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $this->type2
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $this->type2Extension
	        ->shouldReceive('setDefaultOptions')
	        ->ordered()
	        ->with($optionsResolver)
	        ->once()
	        ->getMock()
	    ;
	    $this->type3
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
	    
	    $this->assertEquals($returnedOptions, $this->chain->getOptions($optionsResolver, $options));
	}
	
	public function testGetBuilder()
	{
	    $builder = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface')
	        ->shouldReceive('setTypeChain')
	        ->once()
	        ->with($this->chain)
	        ->getMock()
	    ;
	    $options = array('key' => 'value');
	    $factory = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface');
	    $this->type3
	        ->shouldReceive('createBuilder')
	        ->with($factory, $options)
	        ->ordered()
	        ->once()
	        ->getMock()
	    ;
	    $this->type2
	        ->shouldReceive('createBuilder')
	        ->with($factory, $options)
	        ->ordered()
	        ->once()
	        ->andReturn($builder)
	        ->getMock()
	    ;
	    $this->assertSame($builder, $this->chain->getBuilder($factory, $options));
	}
	
	public function testBuild()
	{
	    $options = array('key' => 'value');
	    $builder = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface');
	    $this->type1
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    $this->type2
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    $this->type2Extension
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
        ;
	    $this->type3
	        ->shouldReceive('build')
	        ->ordered()
	        ->with($builder, $options)
	        ->once()
	        ->getMock()
	    ;
	    
	    $this->chain->build($builder, $options);
	}
	
	public function testFinalize()
	{
	    $options = array('key' => 'value');
	    $object = new \stdClass();
	    $this->type1
	        ->shouldReceive('finalize')
	        ->ordered()
	        ->with($object, $options)
	        ->once()
	        ->getMock()
	    ;
	    $this->type2
	        ->shouldReceive('finalize')
	        ->ordered()
	        ->with($object, $options)
	        ->once()
	        ->getMock()
	    ;
	    
	    $this->chain->finalize($object, $options);
	}
}
