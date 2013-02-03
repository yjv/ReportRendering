<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\PropertyPathType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\RawColumnType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilder;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\ColumnType;

class TypeTestCase extends \PHPUnit_Framework_TestCase{

	protected $builder;
	protected $factory;
	protected $registry;
	protected $dataTransformerRegistry;
	
	protected function setUp() {

		$this->registry = new TypeRegistry();
		$this->registry->set(new ColumnType())->set(new RawColumnType())->set(new PropertyPathType());
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->registry, $this->dataTransformerRegistry);
		$this->builder = new ColumnBuilder($this->factory);
	}
}
