<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\ArrayFilterCollection;

use Yjv\Bundle\ReportRenderingBundle\Datasource\ArrayDatasource;

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
	
	public function testGetData() {
		
		$this->assertEquals($this->data, $this->datasource->getData());
	}
	
	public function testSort() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		
		$filters->set('sort', array('[column2]' => 'asc'));

		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column2'], $b['column2']);});
		$this->assertSame($data, $this->datasource->getData(true));
		
		$filters->set('sort', array('[column1]' => 'asc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column1'], $b['column1']);});
		$this->assertSame($data, $this->datasource->getData(true));
		
		$filters->set('sort', array('[column1]' => 'desc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return -strcasecmp($a['column1'], $b['column1']);});
		$this->assertSame($data, $this->datasource->getData(true));
	}
	
	public function testMappedSort() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		$this->datasource->setSortMap(array('[column1]', '[column2]'));
		
		$filters->set('sort', array(1 => 'asc'));
		
		$data = $this->data;
		uasort($data, function ($a, $b){return strcasecmp($a['column2'], $b['column2']);});
		$this->assertSame($data, $this->datasource->getData(true));
	}
	
	public function testFilters() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		
		$filters->set('[column1]', 'test');
		
		$data = $this->data;
		unset($data[4]);
		$this->assertSame($data, $this->datasource->getData(true));
	}
	
	public function testMappedFIlters() {
		
		$filters = new ArrayFilterCollection();
		$this->datasource->setFilters($filters);
		$this->datasource->setFilterMap(array('column1' => '[column1]'));
		
		$filters->set('column1', 'test');
		
		$data = $this->data;
		unset($data[4]);
		$this->assertSame($data, $this->datasource->getData(true));
	}
}
