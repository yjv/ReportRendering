<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Report\ReportFactory;

use Mockery;

class ReportFactoryTest extends \PHPUnit_Framework_TestCase {

	protected $factory;
	protected $resolver;
	protected $datasourceFactory;
	protected $rendererFactory;
	
	public function setUp(){
		
		$this->resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface');
		$this->datasourceFactory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
		$this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
		$this->factory = new ReportFactory(
	        $this->resolver,
	        $this->datasourceFactory, 
	        $this->rendererFactory
        );
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
