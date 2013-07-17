<?php
namespace Yjv\ReportRendering\Tests\ReportData;

use Yjv\ReportRendering\ReportData\ImmutableReportData;


class ReportDataTest extends ImmutableReportDataTest{

	protected $dataClass = 'Yjv\\ReportRendering\\ReportData\\ReportData';
	
	public function testGettersSetters() {
		
		parent::testGettersSetters();
		
		$data = array('thing3' => 'thing4');
		$unpaginatedCount = 345;
		$this->reportData->setData($data);
		$this->reportData->setUnpaginatedCount($unpaginatedCount);
		
		$this->assertEquals($data, $this->reportData->getData());
		$this->assertEquals($unpaginatedCount, $this->reportData->getUnpaginatedCount());
	}
}
