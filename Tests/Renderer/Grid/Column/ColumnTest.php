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
		$this->transformer1->setConfig(array('map' => array('1' => '2')));
		$this->transformer2->setConfig(array('map' => array('2' => '3')));
		$this->transformer3->setConfig(array('map' => array('3' => '4')));
	}
	
	public function testGetRowOptions() {
		
		$rowOptions = array('option1' => 'fdsdfs');
		$previousOptions = array('option2' => 'sddsfsd');
		
		$this->column->setRowOptions($rowOptions);
		$this->assertEquals($rowOptions, $this->column->getRowOptions());
		$this->assertEquals(array_merge($previousOptions, $rowOptions), $this->column->getRowOptions($previousOptions));
		
		$this->column->setRowOption('option3', function ($data) {
			
			return $data['column1'];
		});
		
		$this->assertEquals(array_merge($previousOptions, array('option1' => 'fdsdfs', 'option3' => 'test')), $this->column->getRowOptions($previousOptions));
		
		$rowOptions['option4'] = new \stdClass();
		
		$this->column->setRowOptions($rowOptions);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getRowOptions($previousOptions);
	}
	
	public function testGetCellOptions() {
		
		$cellOptions = array('option1' => 'fdsdfs');
		
		$this->column->setCellOptions($cellOptions);
		$this->assertEquals($cellOptions, $this->column->getCellOptions());
		
		$this->column->setCellOption('option3', function ($data) {
			
			return $data['column1'];
		});
		
		$this->assertEquals(array('option1' => 'fdsdfs', 'option3' => 'test'), $this->column->getCellOptions());
			
		$cellOptions['option4'] = new \stdClass();
		
		$this->column->setCellOptions($cellOptions);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getCellOptions();
	}
	
	public function testGetOptions() {
		
		$options = array('option1' => 'fdsdfs');
		
		$this->column->setOptions($options);
		$this->assertEquals($options, $this->column->getOptions());
		
		$this->column->setOption('option3', function ($data) {
			
			return $data['column1'];
		});
		
		$this->assertEquals(array('option1' => 'fdsdfs', 'option3' => 'test'), $this->column->getOptions());
				
		$options['option4'] = new \stdClass();
		
		$this->column->setOptions($options);
		
		$this->setExpectedException('InvalidArgumentException');
		$this->column->getOptions();
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
