<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\EscapedColumnType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

class EscapedColumnTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	
	protected function setUp() {

		$this->type = new EscapedColumnType();
	}
	
	public function testGetParent() {
		
		$this->assertEquals('column', $this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('escaped_column', $this->type->getName());
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'escape_output' => true,
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
