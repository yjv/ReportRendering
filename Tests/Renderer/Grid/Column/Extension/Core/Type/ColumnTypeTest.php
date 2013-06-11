<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilder;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\ColumnType;

class ColumnTypeTest extends TypeTestCase{

	protected $type;
	
	protected function setUp() {

		parent::setUp();
		$this->type = new ColumnType();
	}
	
	public function testGetParent() {
		
		$this->assertFalse($this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('column', $this->type->getName());
	}
	
	public function testBuildColumn(){
		
		$options = array('name' => 'column', 'sortable' => true, 'escape_output' => false, 'ignored_option' => 'ignored');
		$this->type->buildColumn($this->builder, $options);
		$column = $this->builder->getColumn();
		$this->assertEquals(array('name' => 'column', 'sortable' => true, 'escape_output' => false), $column->getOptions());
		$this->assertEquals(array('escape_output' => false), $column->getCellOptions());
		$this->assertEmpty($column->getRowOptions());
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'escape_output' => true,
				'sortable' => true,
				'name' => ''
			))
			->will($this->returnValue($optionsResolver))
		;
		$optionsResolver
			->expects($this->once())
			->method('setAllowedTypes')
			->with(array(
				'escape_output' => 'bool',
				'sortable' => 'bool',
				'name' => 'string'
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
	
	public function testCreateBuilder() {
		
		$this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface', $this->type->createBuilder($this->factory, array()));
	}
}
