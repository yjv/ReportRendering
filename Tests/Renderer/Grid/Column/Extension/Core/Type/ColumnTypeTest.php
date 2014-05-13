<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;


use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\ColumnType;

class ColumnTypeTest extends TypeTestCase{

	protected function setUp() {

		parent::setUp();
		$this->type = new ColumnType();
	}
	
	public function testGetParent() {
		
		$this->assertFalse($this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('column', $this->type->getName());
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'sortable' => true,
				'name' => ''
			))
			->will($this->returnValue($optionsResolver))
		;
		$optionsResolver
			->expects($this->once())
			->method('setAllowedTypes')
			->with(array(
				'sortable' => 'bool',
				'name' => 'string'
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
	
	public function testCreateBuilder() {
		
		$this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface', $this->type->createBuilder($this->factory, array()));
	}
}
