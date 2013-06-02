<?php
namespace Yjv\ReportRendering\Tests\ReportData;

use Yjv\ReportRendering\ReportData\ImmutableReportData;


class ReportDataTest extends ImmutableReportDataTest{

	protected $dataClass = 'Yjv\\ReportRendering\\ReportData\\ReportData';
	
	public function testGettersSetters() {
		
		parent::testGettersSetters();
		
		$data = array('thing3' => 'thing4');
		$unfilteredCount = 345;
		$this->reportData->setData($data);
		$this->reportData->setUnfilteredCount($unfilteredCount);
		
		$this->assertEquals($data, $this->reportData->getData());
		$this->assertEquals($unfilteredCount, $this->reportData->getUnfilteredCount());
	}
}
