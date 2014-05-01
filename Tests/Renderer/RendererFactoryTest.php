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
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Renderer\RendererBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetColumnFactory()
	{
	    $this->assertSame($this->columnFactory, $this->factory->getColumnFactory());
	}
}
