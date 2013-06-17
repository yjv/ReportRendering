<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Tests\Factory\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

class TypeTestCase extends BaseTypeTestCase
{
	protected $dataTransformerRegistry;
	
	protected function setUp() {

		parent::setUp();
	    $this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->resolver, $this->dataTransformerRegistry);
		$this->builder = new ColumnBuilder($this->factory);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
