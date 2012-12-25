<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Grid;

class GridTest extends \PHPUnit_Framework_TestCase{

	protected $grid;
	protected $data;
	protected $dataArray;
	
	public function setUp() {
		
		$this->dataArray = array(
		
				array('column1' => 'test', 'column2' => 'noTest3'),
				array('column1' => 'test1', 'column2' => 'noTest2'),
				array('column1' => 'test2', 'column2' => 'noTest1'),
				array('column1' => 'test3', 'column2' => 'noTest'),
		);
		
		$this->data = new ImmutableReportData($this->dataArray, 20);
		
		$this->grid = new Grid();
	}
	
	public function testGettersSetters() {

		$this->grid->setData($this->data);
	}
	
	public function testColumnMethods() {
		
		$column1 = $this->generateColumn();
		$column2 = $this->generateColumn();
		
		$this->grid->addColumn($column1);
		$this->grid->addColumn($column2);
		$columns = $this->grid->getColumns();
		$this->assertCount(2, $columns);
		$this->assertContains($column1, $columns);
		$this->assertContains($column2, $columns);
	}
	
	public function testGetRows() {
		
		$column1 = $this->generateColumn();
		$column2 = $this->generateColumn();
		
		$tester = $this;
		$dataArray = $this->dataArray;
		$expectedCount = count($dataArray) * 2;
		
		$this->grid->addColumn($column1);
		$this->grid->addColumn($column2);
		$this->grid->setData($this->data);
		
		$rowAttributes = array('attribute1' => 'fghdhg');
		$cellAttributes = array('attribute2' => 'sdsfds');
		
		$expectedRowData = array(
				array(
						'attributes' => $rowAttributes, 
						'cells' => array(
								array(
									'attributes' => $cellAttributes,
									'data' => 'test'
								),
								array(
									'attributes' => $cellAttributes,
									'data' => 'noTest3'
								),
						)
				),
				array(
						'attributes' => $rowAttributes, 
						'cells' => array(
								array(
									'attributes' => $cellAttributes,
									'data' => 'test1'
								),
								array(
									'attributes' => $cellAttributes,
									'data' => 'noTest2'
								),
						)
				),
				array(
						'attributes' => $rowAttributes, 
						'cells' => array(
								array(
									'attributes' => $cellAttributes,
									'data' => 'test2'
								),
								array(
									'attributes' => $cellAttributes,
									'data' => 'noTest1'
								),
						)
				),
				array(
						'attributes' => $rowAttributes, 
						'cells' => array(
								array(
									'attributes' => $cellAttributes,
									'data' => 'test3'
								),
								array(
									'attributes' => $cellAttributes,
									'data' => 'noTest'
								),
						)
				)
		);
		
		$column1
			->expects($this->exactly($expectedCount))
			->method('setData')
			->will($this->returnCallback(function($data) use ($tester, $dataArray){
			
				static $count = -1;
				$count++;
				
				$tester->assertEquals($dataArray[$count % count($dataArray)], $data);
			}))
		;
		
		$column1
			->expects($this->exactly($expectedCount))
			->method('getCellAttributes')
			->will($this->returnValue($cellAttributes))
		;
		
		$column1
			->expects($this->exactly($expectedCount))
			->method('getRowAttributes')
			->will($this->returnCallback(function($previousAttributes) use ($tester, $rowAttributes){
			
				$tester->assertEmpty($previousAttributes);
				$savedAttributes = $rowAttributes;
				return $rowAttributes;
			}))
		;
		
		$column1
			->expects($this->exactly($expectedCount))
			->method('getCellData')
			->will($this->returnCallback(function() use ($tester, $dataArray){
			
				static $count = -1;
				$count++;
				
				return $dataArray[$count % count($dataArray)]['column1'];
			}))
		;
		
		$column2
			->expects($this->exactly($expectedCount))
			->method('setData')
			->will($this->returnCallback(function($data) use ($tester, $dataArray){
			
				static $count = -1;
				$count++;
				
				$tester->assertEquals($dataArray[$count % count($dataArray)], $data);
			}))
		;
		
		$column2
			->expects($this->exactly($expectedCount))
			->method('getCellAttributes')
			->will($this->returnValue($cellAttributes))
		;
		
		$column2
			->expects($this->exactly($expectedCount))
			->method('getRowAttributes')
			->will($this->returnCallback(function($previousAttributes) use ($tester, $rowAttributes){
			
				$tester->assertEquals($rowAttributes, $previousAttributes);
				return $rowAttributes;
			}))
		;
		
		$column2
			->expects($this->exactly($expectedCount))
			->method('getCellData')
			->will($this->returnCallback(function() use ($tester, $dataArray){
			
				static $count = -1;
				$count++;
				
				return $dataArray[$count % count($dataArray)]['column2'];
			}))
		;
		
		$this->grid->getRows();
		$this->grid->getRows();
		$rows = $this->grid->getRows(true);
		
		$this->assertEquals($expectedRowData, $rows);
	}
	
	protected function generateColumn(
			$interface = 'ColumnInterface'
	) {
		
		return $this->getMockBuilder('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\Grid\\Column\\'.$interface)->getMock();
	}
}
