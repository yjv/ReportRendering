<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Type;

use Yjv\ReportRendering\Renderer\Grid\Column\Type\RawColumnType;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

class RawColumnTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	
	protected function setUp() {

		parent::setUp();
		$this->type = new RawColumnType();
	}
	
	public function testGetParent() {
		
		$this->assertEquals('column', $this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('raw_column', $this->type->getName());
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'escape_output' => false,
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
