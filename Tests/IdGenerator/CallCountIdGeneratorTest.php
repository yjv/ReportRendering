<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\IdGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Grid;

use Yjv\Bundle\ReportRenderingBundle\Datasource\FakeDatasource;

use Yjv\Bundle\ReportRenderingBundle\Report\Report;

use Yjv\Bundle\ReportRenderingBundle\IdGenerator\CallCountIdGenerator;


class CallCountIdGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function setUp(){
		
		$this->idGenerator = new CallCountIdGenerator();
		$this->report = new Report(new FakeDatasource(), new Grid(), new EventDispatcher());
	}
	
	public function testGetId() {
		
		$this->assertEquals(sha1(1), $this->idGenerator->getId($this->report));
		$this->assertEquals(sha1(2), $this->idGenerator->getId($this->report));
		$this->assertEquals(sha1(3), $this->idGenerator->getId($this->report));
	}
}
