<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Report\ReportFactory;

use Mockery;
use Yjv\TypeFactory\Tests\NamedTypeFactoryTest;

class ReportFactoryTest extends NamedTypeFactoryTest
{
	protected $datasourceFactory;
	protected $rendererFactory;
	
	public function setUp(){
		
		parent::setUp();
		$this->datasourceFactory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
		$this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
		$this->factory = new ReportFactory(
	        $this->resolver,
	        $this->datasourceFactory, 
	        $this->rendererFactory
        );
        $this->builder = Mockery::mock('Yjv\ReportRendering\Report\ReportBuilderInterface');
    }
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Report\ReportBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetRendererFactory()
	{
	    $this->assertSame($this->rendererFactory, $this->factory->getRendererFactory());
	}
	
	public function testGetDatasourceFactory()
	{
	    $this->assertSame($this->datasourceFactory, $this->factory->getDatasourceFactory());
	}
}
