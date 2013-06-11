<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Factory\TypeResolver;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Factory\TypeRegistry;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

class TypeTestCase extends \PHPUnit_Framework_TestCase{

	protected $builder;
	protected $factory;
	protected $resolver;
	protected $registry;
	protected $dataTransformerRegistry;
	
	protected function setUp() {

		$this->registry = new TypeRegistry();
		$this->resolver = new TypeResolver($this->registry);
		
		foreach ($this->getExtensions() as $extension) {
		    
    		$this->registry->addExtension($extension);
		}
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->resolver, $this->dataTransformerRegistry);
		$this->builder = new ColumnBuilder($this->factory);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
