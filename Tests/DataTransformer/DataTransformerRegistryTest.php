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
		$this->assertSame($transformer, $this->registry->get($name));
		
		try {
			$this->registry->get('nonExistent');
			$this->fail('did not throw exception when asked for non-existent transformer');
		} catch (DataTransformerNotFoundException $e) {
		}
	}
}
