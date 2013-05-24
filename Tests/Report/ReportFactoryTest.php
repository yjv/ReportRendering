<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Report;

use Yjv\Bundle\ReportRenderingBundle\Report\ReportFactory;

class ReportFactoryTest extends \PHPUnit_Framework_TestCase {

	protected $factory;
	protected $registry;
	
	public function setUp(){
		
		$this->registry = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Report\ReportTypeRegistry')->getMock();
		$this->factory = new ReportFactory($this->registry);
	}
	
	public function test() {
		
		$reportType = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Report\ReportTypeInterface')->getMock();
		$typeName = 'type';
		
		$this->registry
			->expects($this->once())
			->method('get')
			->with($typeName)
			->will($this->returnValue($reportType))
		;
		
		$this->assertSame($reportType, $this->factory->getType($typeName));
	}
}
