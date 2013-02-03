<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilder;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\MappedDataTransformer;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

class ColumnBuilderTest extends \PHPUnit_Framework_TestCase {

	protected $builder;
	protected $columnFactory;
	
	public function setUp() {
		
		$this->columnFactory = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory')->disableOriginalConstructor()->getMock();
		$this->builder = new ColumnBuilder($this->columnFactory);
	}
	
	public function testGetRowOptions() {
		
		$rowOptions = array('option1' => 'fdsdfs');
		
		$this->assertSame($this->builder, $this->builder->setRowOptions($rowOptions));
		$this->assertEquals($rowOptions, $this->builder->getRowOptions());
		
		$this->assertSame($this->builder, $this->builder->setRowOption('option3', 'test'));
		
		$this->assertEquals(array('option1' => 'fdsdfs', 'option3' => 'test'), $this->builder->getRowOptions());
	}
	
	public function testGetCellOptions() {
		
		$cellOptions = array('option1' => 'fdsdfs');
		
		$this->assertSame($this->builder, $this->builder->setCellOptions($cellOptions));
		$this->assertEquals($cellOptions, $this->builder->getCellOptions());
		
		$this->assertSame($this->builder, $this->builder->setCellOption('option3', 'test'));
		
		$this->assertEquals(array('option1' => 'fdsdfs', 'option3' => 'test'), $this->builder->getCellOptions());
	}
	
	public function testGetOptions() {
		
		$options = array('option1' => 'fdsdfs');
		
		$this->assertSame($this->builder, $this->builder->setOptions($options));
		$this->assertEquals($options, $this->builder->getOptions());
		
		$this->assertSame($this->builder, $this->builder->setOption('option3', 'test'));
		
		$this->assertEquals(array('option1' => 'fdsdfs', 'option3' => 'test'), $this->builder->getOptions());
	}
	
	public function testDatatransformerGetterSetter() {
		
		$transformer1 = new MappedDataTransformer();
		$transformer2 = new MappedDataTransformer();
		$transformer3 = new MappedDataTransformer();
		
		$dataTransformers = array($transformer2);
		$this->assertSame($this->builder, $this->builder->setDataTransformers($dataTransformers));
		$this->assertSame($dataTransformers, $this->builder->getDataTransformers());
		$this->assertSame($this->builder, $this->builder->appendDataTransformer($transformer3));
		$dataTransformers[] = $transformer3;
		$this->assertSame($dataTransformers, $this->builder->getDataTransformers());
		array_unshift($dataTransformers, $transformer1);
		$this->assertSame($this->builder, $this->builder->prependDataTransformer($transformer1));
		$this->assertSame($dataTransformers, $this->builder->getDataTransformers());
	}
	
	public function testGetColumnFactory() {
		
		$this->assertSame($this->columnFactory, $this->builder->getColumnFactory());
	}
	
	public function testGetDataTransformerRegistry() {
		
		$dataTransformerRegistry = $this->getMock('Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry');
		$this->columnFactory->expects($this->once())->method('getDataTransformerRegistry')->will($this->returnValue($dataTransformerRegistry));
		$this->assertSame($dataTransformerRegistry, $this->builder->getDataTransformerRegistry());
	}
	
	public function testGetColumn() {
		
		$options = array('options1' => 'value1');
		$rowOptions = array('option2' => 'value2');
		$cellOptions = array('option3' => 'value3');
		$dataTransformers = array(new MappedDataTransformer());
		
		$column = $this->builder
			->setOptions($options)
			->setRowOptions($rowOptions)
			->setCellOptions($cellOptions)
			->setDataTransformers($dataTransformers)
			->getColumn()
		;
		
		$this->assertEquals($options, $column->getOptions());
		$this->assertEquals($rowOptions, $column->getRowOptions());
		$this->assertEquals($cellOptions, $column->getCellOptions());
		$this->assertEquals($dataTransformers, $column->getDataTransformers());
	}
}
