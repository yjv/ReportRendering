<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Report;

use Yjv\Bundle\ReportRenderingBundle\Report\ReportTypeRegistry;

class ReportTypeRegistryTest extends \PHPUnit_Framework_TestCase {

	protected $registry;
	
	public function setUp(){
		
		$this->registry = new ReportTypeRegistry();
	}
	
	public function testGettersSetters() {
	
		$reportType1 = $this->getMockBuilder('Yjv\\Bundle\\ReportRenderingBundle\\Report\\ReportTypeInterface')->getMock();
		$reportType2 = $this->getMockBuilder('Yjv\\Bundle\\ReportRenderingBundle\\Report\\ReportTypeInterface')->getMock();
		$reportType1Name = 'reportType1Name';
		$reportType2Name = 'reportType2Name';
		$reportType3Name = 'reportType3Name';
	
		$reportType1
			->expects($this->once())
			->method('getName')
			->will($this->returnValue($reportType1Name))
		;
		
		$reportType2
			->expects($this->once())
			->method('getName')
			->will($this->returnValue($reportType2Name))
		;
		
		$this->registry->set($reportType1);
		$this->registry->set($reportType2);
	
		$this->assertSame($reportType1, $this->registry->get($reportType1Name));
		$this->assertSame($reportType2, $this->registry->get($reportType2Name));
	
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\Report\ReportTypeNotFoundException');
		$this->registry->get($reportType3Name);
	}
}
