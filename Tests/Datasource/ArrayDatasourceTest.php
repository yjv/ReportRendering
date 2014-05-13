<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\FilterConstants;


use Yjv\ReportRendering\Datasource\ArrayDatasource;

class ArrayDatasourceTest extends \PHPUnit_Framework_TestCase{

	/** @var  ArrayDatasource */
    protected $datasource;
	protected $data;
	
	public function setUp() {
		
		$this->data = array(
		
				array('column1' => 'test', 'column2' => 'noTest3'),
				array('column1' => 'test1', 'column2' => 'noTest2'),
				array('column1' => 'test2', 'column2' => 'noTest1'),
				array('column1' => 'test3', 'column2' => 'noTest'),
				array('column1' => 'badData', 'column2' => 'noTest'),
		);
		$this->datasource = new ArrayDatasource($this->data);
	}
	
	public function testConstructor() {
		
		try {
			new ArrayDatasource(new \stdClass());
			$this->fail('did not throw exception on invalid data');
		} catch (\InvalidArgumentException $e) {}
		
		$datasource = new ArrayDatasource(new \ArrayIterator(array()));
		$data = $datasource->getData(array());
		$this->assertInstanceOf('Yjv\ReportRendering\ReportData\DataInterface', $data);
		$this->assertInternalType('array', $data->getData());
	}
	
	public function testGetData() {
		
		$data = $this->datasource->getData(array());
		$this->assertSame($this->data, $data->getData());
	}
	
	public function testSort() {
		
		$filterValues = array();

		$filterValues[FilterConstants::SORT] = array('[column2]' => FilterConstants::SORT_ORDER_ASCENDING);

		$data = $this->data;
		usort($data, function ($a, $b){return strcasecmp($a['column2'], $b['column2']);});
		
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($data, $dataObject->getData());
		
		$filterValues[FilterConstants::SORT] = array('[column1]' => FilterConstants::SORT_ORDER_ASCENDING);
		
		$data = $this->data;
		usort($data, function ($a, $b){return strcasecmp($a['column1'], $b['column1']);});
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($data, $dataObject->getData());
		
		$filterValues[FilterConstants::SORT] = array('[column1]' => FilterConstants::SORT_ORDER_DESCENDING);
		
		$data = $this->data;
		usort($data, function ($a, $b){return -strcasecmp($a['column1'], $b['column1']);});
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($data, $dataObject->getData());
	}
	
	public function testFilters() {
		
		$filterValues = array();

		$filterValues['[column1]'] = 'test';
		
		$data = $this->data;
		unset($data[4]);
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($data, $dataObject->getData());
		
	}
	
	public function testEmptyFilterValueDoesNotRemoveEntry()
	{
        $filterValues = array();
        $filterValues['[column1]'] = '';
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($this->data, $dataObject->getData());
	}
	
	public function testMappedFilters() {
		
		$filterValues = array('column1' => 'test');
		$this->datasource->setFilterMap(array('column1' => '[column1]'));
		
		$data = $this->data;
		unset($data[4]);
		$dataObject = $this->datasource->getData($filterValues);
		$this->assertSame($data, $dataObject->getData());
	}
	
	public function testLimitAndOffset()
	{
	    $filterValues = array(FilterConstants::LIMIT => 3, FilterConstants::OFFSET => 1);
	    $this->assertSame(array_slice($this->data, 1, 3), $this->datasource->getData($filterValues)->getData());
	}
}
