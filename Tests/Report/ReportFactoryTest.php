<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Report\ReportFactory;

use Mockery;

class ReportFactoryTest extends \PHPUnit_Framework_TestCase {

	protected $factory;
	protected $resolver;
	protected $rendererFactory;
	
	public function setUp(){
		
		$this->resolver = Mockery::mock('Yjv\ReportRendering\Factory\TypeResolverInterface');
		$this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
		$this->factory = new ReportFactory($this->resolver, $this->rendererFactory);
	}
	
	public function testCreate()
	{
	    $factory = $this
			->getMockBuilder(get_class($this->factory))
			->disableOriginalConstructor()
			->setMethods(array('createBuilder'))
			->getMock()
	    ;
	    
	    $type = 'type';
	    $options = array('key' => 'value');
	    $report = Mockery::mock('Yjv\ReportRendering\Report\ReportInterface');
	    
	    $typeChain = Mockery::mock('Yjv\ReportRendering\Factory\TypeChainInterface')
	        ->shouldReceive('finalize')
	        ->with($report, $options)
	        ->once()
	        ->getMock()
	    ;
	    
	    $builder = Mockery::mock('Yjv\ReportRendering\Report\ReportBuilderInterface')
	        ->shouldReceive('getTypeChain')
	        ->once()
	        ->andReturn($typeChain)
	        ->getMock()
	        ->shouldReceive('getOptions')
	        ->once()
	        ->andReturn($options)
	        ->getMock()
	        ->shouldReceive('getReport')
	        ->once()
	        ->andReturn($report)
	        ->getMock()
	    ;
	    
	    $factory
    	    ->expects($this->once())
    	    ->method('createBuilder')
    	    ->with($type, $options)
    	    ->will($this->returnValue($builder))
	    ;
	    
	    $this->assertSame($report, $factory->create($type, $options));
	}
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Report\ReportBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetRendererFactory()
	{
	    $this->assertSame($this->rendererFactory, $this->factory->getRendererFactory());
	}
}
