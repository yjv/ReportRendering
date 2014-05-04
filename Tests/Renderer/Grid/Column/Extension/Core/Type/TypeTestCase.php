<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\TypeFactory\Tests\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

class TypeTestCase extends BaseTypeTestCase
{
	protected $dataTransformerRegistry;
	
	protected function setUp() {

		parent::setUp();
		$this->factory = new ColumnFactory($this->resolver);
		$this->builder = new ColumnBuilder($this->factory);
        $this->mockedBuilder = \Mockery::mock(get_class($this->builder));
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
