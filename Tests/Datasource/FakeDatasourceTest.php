<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Filter\NullFilterCollection;

use Yjv\ReportRendering\Datasource\FakeDatasource;

class FakeDatasourceTest extends \PHPUnit_Framework_TestCase {

	protected $datasource;
	
	public function setUp() {
		
		$this->datasource = new FakeDatasource();
	}
	
	public function testGettersSetter() {
		
		$this->datasource->setFilters(new NullFilterCollection());
		
		$reportData = $this->datasource->getData();
		$this->assertNotEmpty($reportData->getData());
		$this->assertNotEmpty($reportData->getCount());
		$this->assertNotEmpty($reportData->getUnfilteredCount());
	}
}
