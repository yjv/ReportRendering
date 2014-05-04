<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Report\ReportFactory;

use Mockery;
use Yjv\TypeFactory\Tests\TypeFactoryTest;

class RendererFactoryTest extends TypeFactoryTest
{
	protected $columnFactory;
	
	public function setUp(){
		
		parent::setUp();
		$this->columnFactory = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface');
		$this->factory = new RendererFactory($this->resolver, $this->columnFactory);
        $this->builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface');
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
