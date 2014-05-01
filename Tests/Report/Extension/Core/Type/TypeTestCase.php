<?php
namespace Yjv\ReportRendering\Tests\Report\Extension\Core\Type;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Report\ReportBuilder;

use Yjv\ReportRendering\Report\ReportFactory;

use Yjv\TypeFactory\Tests\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Mockery;

class TypeTestCase extends BaseTypeTestCase
{
	protected $datasourceFactory;
	protected $rendererFactory;
	protected $eventDispatcher;
    
    protected function setUp()
	{
	    parent::setUp();
		$this->datasourceFactory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
	    $this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
		$this->eventDispatcher = Mockery::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
	    
	    $this->factory = new ReportFactory($this->resolver, $this->datasourceFactory, $this->rendererFactory);
		$this->builder = new ReportBuilder('report', $this->factory, $this->eventDispatcher);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
