<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;

use Yjv\ReportRendering\DataTransformer\DataTransformerNotFoundException;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

class DataTransformerRegistryTest extends \PHPUnit_Framework_TestCase{

	protected $registry;
	
	public function setUp(){
		
		$this->registry = new DataTransformerRegistry();
	}
	
	public function testSetGet() {
		
		$transformer = $this->getMock('Yjv\\ReportRendering\\DataTransformer\\DataTransformerInterface');
		$name = 'trans';
		$this->registry->set($name, $transformer);
		
		$this->assertNotSame($transformer, $this->registry->get($name));
		$this->assertEquals($transformer, $this->registry->get($name));
		
		$this->setExpectedException('Yjv\ReportRendering\DataTransformer\DataTransformerNotFoundException');
		$this->registry->get('nonExistent');
	}
}
