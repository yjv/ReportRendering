<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\ColumnType;

class ColumnTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	
	protected function setUp() {

		$this->type = new ColumnType();
	}
	
	public function testGetParent() {
		
		$this->assertFalse($this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('column', $this->type->getName());
	}
	
	public function testBuildColumn(){
		
		$options = array('name' => 'column', 'sortable' => true, 'escape_output' => false, 'ignored_option' => 'ignored');
		$column = new Column();
		$this->type->buildColumn($column, $options);
		$this->assertEquals(array('name' => 'column', 'sortable' => true, 'escape_output' => false), $column->getOptions());
		$this->assertEquals(array('escape_output' => false), $column->getCellOptions());
		$this->assertEmpty($column->getRowOptions());
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'escape_output' => false,
				'sortable' => true,
				'name' => ''
			))
			->will($this->returnValue($optionsResolver))
		;
		$optionsResolver
			->expects($this->once())
			->method('setAllowedTypes')
			->with(array(
				'escape_output' => 'bool',
				'sortable' => 'bool',
				'name' => 'string'
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
