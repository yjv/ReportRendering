<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry;

class DataTransformerRegistryTest extends \PHPUnit_Framework_TestCase{

	protected $registry;
	
	public function setUp(){
		
		$this->registry = new DataTransformerRegistry();
	}
	
	public function testAddGet() {
		
		$transformer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\DataTransformer\\DataTransformerInterface');
		$name = 'trans';
		$this->registry->add($name, $transformer);
		
		$this->assertNotSame($transformer, $this->registry->get($name));
		$this->assertEquals($transformer, $this->registry->get($name));
		
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerNotFoundException');
		$this->registry->get('nonExistent');
	}
}
