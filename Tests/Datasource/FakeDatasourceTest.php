<?php
namespace Yjv\ReportRendering\Tests\Datasource;



use Yjv\ReportRendering\Datasource\FakeDatasource;

class FakeDatasourceTest extends \PHPUnit_Framework_TestCase {

	protected $datasource;
	
	public function setUp() {
		
		$this->datasource = new FakeDatasource();
	}
	
	public function testGettersSetter() {
		
		$reportData = $this->datasource->getData(array());
		$this->assertNotEmpty($reportData->getData(array()));
		$this->assertNotEmpty($reportData->getCount());
		$this->assertNotEmpty($reportData->getUnpaginatedCount());
	}
}
