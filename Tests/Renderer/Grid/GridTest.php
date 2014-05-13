<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid;

use Yjv\ReportRendering\ReportData\ImmutableReportData;

use Yjv\ReportRendering\Renderer\Grid\Grid;

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
		
		$rowOptions = array('option1' => 'fghdhg');
		$cellOptions = array('option2' => 'sdsfds');
		
		$expectedRowData = array(
				array(
						'options' => $rowOptions, 
						'cells' => array(
								array(
									'options' => $cellOptions,
									'data' => 'test'
								),
								array(
									'options' => $cellOptions,
									'data' => 'noTest3'
								),
						)
				),
				array(
						'options' => $rowOptions, 
						'cells' => array(
								array(
									'options' => $cellOptions,
									'data' => 'test1'
								),
								array(
									'options' => $cellOptions,
									'data' => 'noTest2'
								),
						)
				),
				array(
						'options' => $rowOptions, 
						'cells' => array(
								array(
									'options' => $cellOptions,
									'data' => 'test2'
								),
								array(
									'options' => $cellOptions,
									'data' => 'noTest1'
								),
						)
				),
				array(
						'options' => $rowOptions, 
						'cells' => array(
								array(
									'options' => $cellOptions,
									'data' => 'test3'
								),
								array(
									'options' => $cellOptions,
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
			->method('getCellOptions')
			->will($this->returnValue($cellOptions))
		;
		
		$column1
			->expects($this->exactly($expectedCount))
			->method('getRowOptions')
			->will($this->returnCallback(function($previousOptions) use ($tester, $rowOptions){
			
				$tester->assertEmpty($previousOptions);
				return $rowOptions;
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
			->method('getCellOptions')
			->will($this->returnValue($cellOptions))
		;
		
		$column2
			->expects($this->exactly($expectedCount))
			->method('getRowOptions')
			->will($this->returnCallback(function($previousOptions) use ($tester, $rowOptions){
			
				$tester->assertEquals($rowOptions, $previousOptions);
				return $rowOptions;
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
		$this->grid->setForceReload(true);
		$rows = $this->grid->getRows();
		$this->grid->setForceReload(false);
		
		$this->assertEquals($expectedRowData, $rows);
		$this->assertEquals($expectedRowData, iterator_to_array($this->grid));
	}
	
	/**
	 * @expectedException \BadMethodCallException
	 * @expectedExceptionMessage data must be set to use this method
	 */
	public function testGetRowsWithDataNotSet()
	{
	    $this->grid->getRows();
	}
	
	protected function generateColumn(
			$interface = 'ColumnInterface'
	) {
		
		return $this->getMockBuilder('Yjv\\ReportRendering\\Renderer\\Grid\\Column\\'.$interface)->getMock();
	}
}
