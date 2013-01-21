<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererRegistry;

class RendererRegistryTest extends \PHPUnit_Framework_TestCase{

	protected $rendererRegistry;
	
	public function setUp() {
		
		$this->rendererRegistry = new RendererRegistry();
	}
	
	public function testGettersSetters() {
		
		$renderer1 = $this->getMockBuilder('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\RendererInterface')->getMock();
		$renderer2 = $this->getMockBuilder('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\RendererInterface')->getMock();
		$renderer1Name = 'renderer1Name';
		$renderer2Name = 'renderer2Name';
		$renderer3Name = 'renderer3Name';
		
		$this->rendererRegistry->set($renderer1Name, $renderer1);
		$this->rendererRegistry->set($renderer2Name, $renderer2);
		
		$this->assertNotSame($renderer1, $this->rendererRegistry->get($renderer1Name));
		$this->assertNotSame($renderer2, $this->rendererRegistry->get($renderer2Name));
		$this->assertEquals($renderer1, $this->rendererRegistry->get($renderer1Name));
		$this->assertEquals($renderer2, $this->rendererRegistry->get($renderer2Name));
		
		try {
			
			$this->rendererRegistry->get($renderer3Name);
			$this->fail('Failed to throw exception on non existant renderer');
		} catch (RendererNotFoundException $e) {
		}
	}
}
