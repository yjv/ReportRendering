<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

use Yjv\Bundle\ReportRenderingBundle\Datasource\FakeDatasource;

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
