<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Filter\ArrayFilterCollection;

use Yjv\ReportRendering\Datasource\ArrayDatasource;

class ArrayDatasourceTest extends \PHPUnit_Framework_TestCase{

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
		$data = $datasource->getData();
		$this->assertInstanceOf('Yjv\ReportRendering\ReportData\DataInterface', $data);
		$this->assertInternalType('array', $data->getData());
	}
	
	public function testGetData() {
		
		$data = $this->datasource->getData();
		$this->assertSame($this->data, $data->getData());
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		
		$filters->set('[column1]', 'test');
		
		$data = $this->datasource->getData(false);
		$this->assertSame($this->data, $data->getData());
		$data = $this->datasource->getData();
		$this->assertSame($this->data, $data->getData());
	}
	
	public function testSort() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		
		$filters->set('sort', array('[column2]' => 'asc'));

		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column2'], $b['column2']);});
		
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
		
		$filters->set('sort', array('[column1]' => 'asc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column1'], $b['column1']);});
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
		
		$filters->set('sort', array('[column1]' => 'desc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return -strcasecmp($a['column1'], $b['column1']);});
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
	}
	
	public function testMappedSort() {
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		$this->datasource->setSortMap(array('[column1]', '[column2]'));
		
		$filters->set('sort', array(1 => 'asc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column2'], $b['column2']);});
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
	}
	
	public function testFilters() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		
		$filters->set('[column1]', 'test');
		
		$data = $this->data;
		unset($data[4]);
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
	}
	
	public function testMappedFilters() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		$this->datasource->setFilterMap(array('column1' => '[column1]'));
		
		$filters->set('column1', 'test');
		
		$data = $this->data;
		unset($data[4]);
		$dataObject = $this->datasource->getData(true);
		$this->assertSame($data, $dataObject->getData());
	}
}
