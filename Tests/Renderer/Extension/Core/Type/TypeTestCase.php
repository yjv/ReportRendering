<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type;



use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;

use Yjv\TypeFactory\Tests\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Mockery;

class TypeTestCase extends BaseTypeTestCase
{
	protected $columnFactory;
    
    protected function setUp()
	{
	    parent::setUp();
		$this->columnFactory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
	    
	    $this->factory = new RendererFactory($this->resolver, $this->columnFactory);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
