<?php
namespace Yjv\ReportRendering\Tests\IdGenerator;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Yjv\ReportRendering\Datasource\FakeDatasource;

use Yjv\ReportRendering\Report\Report;

use Yjv\ReportRendering\IdGenerator\CallCountIdGenerator;


class CallCountIdGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function setUp(){
		
		$this->idGenerator = new CallCountIdGenerator();
		$renderer = $this->getMockBuilder('Yjv\ReportRendering\Renderer\RendererInterface')->getMock();
		$this->report = new Report(new FakeDatasource(), $renderer, new EventDispatcher());
	}
	
	public function testGetId() {
		
		$this->assertEquals(sha1(1), $this->idGenerator->getId($this->report));
		$this->assertEquals(sha1(2), $this->idGenerator->getId($this->report));
		$this->assertEquals(sha1(3), $this->idGenerator->getId($this->report));
	}
	
	public function testGetIdWithPrefix()
	{
	    $idGenerator = new CallCountIdGenerator('prefix');
	    $this->assertEquals(sha1('prefix1'), $idGenerator->getId($this->report));
	    $this->assertEquals(sha1('prefix2'), $idGenerator->getId($this->report));
	    $this->assertEquals(sha1('prefix3'), $idGenerator->getId($this->report));
	    $this->assertSame($idGenerator, $idGenerator->setPrefix('other_prefix'));
	    $this->assertEquals(sha1('other_prefix4'), $idGenerator->getId($this->report));
	    $this->assertEquals('other_prefix', $idGenerator->getPrefix());
	}
}
