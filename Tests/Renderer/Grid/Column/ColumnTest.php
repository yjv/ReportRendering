<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\MappedDataTransformer;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

class ColumnTest extends \PHPUnit_Framework_TestCase {

	protected $column;
	
	public function setUp() {
		
		$this->column = new Column();
		$this->data = array('column1' => 'test', 'column2' => 'noTest3');
		$this->column->setData($this->data);
		
		$this->transformer1 = new MappedDataTransformer();
		$this->transformer2 = new MappedDataTransformer();
		$this->transformer3 = new MappedDataTransformer();
		$this->transformer1->setOptions(array('map' => array('1' => '2')));
		$this->transformer2->setOptions(array('map' => array('2' => '3')));
		$this->transformer3->setOptions(array('map' => array('3' => '4')));
	}
	
	public function testGetRowAttributes() {
		
		$rowAttributes = array('attribute1' => 'fdsdfs');
		$previousAttributes = array('attribute2' => 'sddsfsd');
		
		$this->column->setRowAttributes($rowAttributes);
		$this->assertEquals($rowAttributes, $this->column->getRowAttributes());
		$this->assertEquals(array_merge($previousAttributes, $rowAttributes), $this->column->getRowAttributes($previousAttributes));
		
		$rowAttributes['attribute3'] = function ($data) {
			
			return $data['column1'];
		};
		
		$this->column->setRowAttributes($rowAttributes);
		$this->assertEquals(array_merge($previousAttributes, array('attribute1' => 'fdsdfs', 'attribute3' => 'test')), $this->column->getRowAttributes($previousAttributes));
		
		$rowAttributes['attribute4'] = new \stdClass();
		
		$this->column->setRowAttributes($rowAttributes);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getRowAttributes($previousAttributes);
	}
	
	public function testGetCellAttributes() {
		
		$cellAttributes = array('attribute1' => 'fdsdfs');
		
		$this->column->setCellAttributes($cellAttributes);
		$this->assertEquals($cellAttributes, $this->column->getCellAttributes());
		
		$cellAttributes['attribute3'] = function ($data) {
			
			return $data['column1'];
		};
		
		$this->column->setCellAttributes($cellAttributes);
		$this->assertEquals(array('attribute1' => 'fdsdfs', 'attribute3' => 'test'), $this->column->getCellAttributes());
			
		$cellAttributes['attribute4'] = new \stdClass();
		
		$this->column->setCellAttributes($cellAttributes);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getCellAttributes();
	}
	
	public function testGetAttributes() {
		
		$attributes = array('attribute1' => 'fdsdfs');
		
		$this->column->setAttributes($attributes);
		$this->assertEquals($attributes, $this->column->getAttributes());
		
		$attributes['attribute3'] = function ($data) {
			
			return $data['column1'];
		};
		
		$this->column->setAttributes($attributes);
		$this->assertEquals(array('attribute1' => 'fdsdfs', 'attribute3' => 'test'), $this->column->getAttributes());
				
		$attributes['attribute4'] = new \stdClass();
		
		$this->column->setAttributes($attributes);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getAttributes();
	}
	
	public function testGetCellData() {
		
		$this->column->setData('1');
		$this->column->setDataTransformers(array($this->transformer1, $this->transformer2, $this->transformer3));
		$this->assertEquals('4', $this->column->getCellData());
	}
	
	public function testGetCellDataWithAppendPrependTransformers() {
		
		$this->column->setData('1');
		$this->column->appendDataTransformer($this->transformer2);
		$this->column->appendDataTransformer($this->transformer3);
		$this->column->prependDataTransformer($this->transformer1);
		$this->assertEquals('4', $this->column->getCellData());
	}
	
	public function testGetCellDataWithFalseCallback() {
		
		$tester = $this;
		
		$callback = function($data, $originalData) use ($tester){
			
			$tester->assertEquals('3', $data);
			$tester->assertEquals('1', $originalData);
			
			return false;
		};
		
		$this->column->setData('1');
		$this->column->setDataTransformers(array($this->transformer1, $this->transformer2, $callback, $this->transformer3));
		$this->assertEquals('3', $this->column->getCellData());
	}
	
	public function testGetCellDataWithTrueCallback() {
		
		$tester = $this;
		
		$callback = function($data, $originalData) use ($tester){
			
			$tester->assertEquals('3', $data);
			$tester->assertEquals('1', $originalData);
			
			return true;
		};
		
		$this->column->setData('1');
		$this->column->setDataTransformers(array($this->transformer1, $this->transformer2, $callback, $this->transformer3));
		$this->assertEquals('4', $this->column->getCellData());
	}
	
	public function testGetCellDataWithBadTransformer() {
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->setData('1');
		$this->column->setDataTransformers(array($this->transformer1, $this->transformer2, new \stdClass(), $this->transformer3));
		$this->column->getCellData();
	}
}
