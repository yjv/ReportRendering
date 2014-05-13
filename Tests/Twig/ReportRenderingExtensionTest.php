<?php
namespace Yjv\ReportRendering\Tests\Twig;


use Yjv\ReportRendering\Twig\ReportRenderingExtension;

class ReportRenderingExtensionTest extends \PHPUnit_Framework_TestCase {

	/** @var ReportRenderingExtension  */
    protected $extension;
	
	public function setUp() {
		
		$this->extension = new ReportRenderingExtension();
	}
	
	public function testGettersSetters() {
		
		$filters = $this->extension->getFilters();
		$this->assertArrayHasKey('trans', $filters);
		$attributesMethod = $filters['trans'];
		$this->assertInstanceOf('Twig_Filter_Method', $attributesMethod);
		
		$this->assertEquals('report_rendering', $this->extension->getName());
	}
	
	public function testTrans() {

        $value = 'value';
		$this->assertEquals($value, $this->extension->trans($value));
	}
}
