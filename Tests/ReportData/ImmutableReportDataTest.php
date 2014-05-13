<?php
namespace Yjv\ReportRendering\Tests\ReportData;




class ImmutableReportDataTest extends \PHPUnit_Framework_TestCase{

	protected $data;
	protected $unpaginatedCount;
	protected $dataClass = 'Yjv\\ReportRendering\\ReportData\\ImmutableReportData';
	protected $reportData;
	
	public function setUp() {
		
		$this->data = array('thing1' => 'thing2');
		$this->unpaginatedCount = 15;
		$class = $this->dataClass;
		$this->reportData = new $class($this->data, $this->unpaginatedCount);
	}
	
	public function testConstructor() {
		
		try {
			
			$class = $this->dataClass;
			new $class('sdfdsf', $this->unpaginatedCount);
			$this->fail('failed to throw exception on bad data param');
		} catch (\InvalidArgumentException $e) {
		}
	}
	
	public function testGettersSetters() {
		
		$this->assertEquals($this->data, $this->reportData->getData());
		$this->assertEquals($this->unpaginatedCount, $this->reportData->getUnpaginatedCount());
		$this->assertEquals(count($this->data), $this->reportData->getCount());
	}
}
