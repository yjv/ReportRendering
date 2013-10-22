<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Report\ReportFactory;

use Mockery;

class RendererFactoryTest extends \PHPUnit_Framework_TestCase {

	protected $factory;
	protected $resolver;
	protected $columnFactory;
	
	public function setUp(){
		
		$this->resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface');
		$this->columnFactory = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface');
		$this->factory = new RendererFactory($this->resolver, $this->columnFactory);
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
	    $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
	    
	    $builder = Mockery::mock('Yjv\ReportRendering\Report\ReportBuilderInterface')
	        ->shouldReceive('getRenderer')
	        ->once()
	        ->andReturn($renderer)
	        ->getMock()
	    ;
	    
	    $factory
    	    ->expects($this->once())
    	    ->method('createBuilder')
    	    ->with($type, $options)
    	    ->will($this->returnValue($builder))
	    ;
	    
	    $this->assertSame($renderer, $factory->create($type, $options));
	}
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Renderer\RendererBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetColumnFactory()
	{
	    $this->assertSame($this->columnFactory, $this->factory->getColumnFactory());
	}
}
