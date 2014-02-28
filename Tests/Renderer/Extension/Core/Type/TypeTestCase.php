<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Tests\Factory\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Mockery;

class TypeTestCase extends BaseTypeTestCase
{
	protected $columnFactory;
    
    protected function setUp()
	{
	    parent::setUp();
		$this->columnFactory = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface');
	    
	    $this->factory = new RendererFactory($this->resolver, $this->columnFactory);
		$this->builder = new AbstractRendererBuilder($this->factory);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
