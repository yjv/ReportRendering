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
		
		$this->rendererRegistry->addRenderer($renderer1Name, $renderer1);
		$this->rendererRegistry->addRenderer($renderer2Name, $renderer2);
		
		$this->assertSame($renderer1, $this->rendererRegistry->getRenderer($renderer1Name));
		$this->assertSame($renderer2, $this->rendererRegistry->getRenderer($renderer2Name));
		
		try {
			
			$this->rendererRegistry->getRenderer($renderer3Name);
			$this->fail('Failed to throw exception on non existant renderer');
		} catch (RendererNotFoundException $e) {
		}
	}
}
