<?php
namespace Yjv\ReportRendering\Tests\Twig;

use Yjv\ReportRendering\Twig\ReportRenderingExtension;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportRenderingExtensionTest extends \PHPUnit_Framework_TestCase {

	protected $extension;
	
	public function setUp() {
		
		$this->extension = new ReportRenderingExtension();
	}
	
	public function testGettersSetters() {
		
		$filters = $this->extension->getFilters();
		$this->assertArrayHasKey('attributes', $filters);
		$attributesMethod = $filters['attributes'];
		$this->assertInstanceOf('Twig_Filter_Method', $attributesMethod);
		
		$this->assertEquals('report_rendering_extension', $this->extension->getName());
	}
	
	public function testAttributes() {
		
		$attributes = array('name' => 'thing1', 'id' => 'thing2');
		$defaults = array('id' => 'thing3', 'style' => 'thing4');
		
		$this->assertEquals(' name="thing1" id="thing2" ', $this->extension->attributes($attributes));
		$this->assertEquals(' id="thing2" style="thing4" name="thing1" ', $this->extension->attributes($attributes, $defaults));
		
		$attributes['class'] = 'class1'; 
		$defaults['class'] = 'class2'; 
		$this->assertEquals(' id="thing2" style="thing4" class="class1 class2" name="thing1" ', $this->extension->attributes($attributes, $defaults));
	}
}
