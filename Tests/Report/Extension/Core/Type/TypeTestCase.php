<?php
namespace Yjv\ReportRendering\Tests\Report\Extension\Core\Type;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Report\ReportBuilder;

use Yjv\ReportRendering\Report\ReportFactory;

use Yjv\ReportRendering\Tests\Factory\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Mockery;

class TypeTestCase extends BaseTypeTestCase
{
	protected $rendererFactory;
	protected $eventDispatcher;
    
    protected function setUp()
	{
	    parent::setUp();
		$this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
		$this->eventDispatcher = Mockery::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
	    
	    $this->factory = new ReportFactory($this->resolver, $this->rendererFactory);
		$this->builder = new ReportBuilder($this->factory, $this->eventDispatcher);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
