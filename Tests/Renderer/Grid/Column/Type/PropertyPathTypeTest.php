<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\PropertyPathType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

class PropertyPathTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	
	protected function setUp() {

		$this->type = new PropertyPathType();
	}
	
	public function testGetParent() {
		
		$this->assertEquals('escaped_column', $this->type->getParent());
	}

	public function testGetName() {
		
		$this->assertEquals('property_path', $this->type->getName());
	}
	
	public function testBuildColumn(){
		
		$options = array('path' => 'column', 'required' => true, 'empty_value' => '', 'ignored_option' => 'ignored');
		$column = new Column();
		$this->type->buildColumn($column, $options);
		$dataTransformers = $column->getDataTransformers();
		$this->assertCount(1, $dataTransformers);
		$transformer = $dataTransformers[0];
		$this->assertInstanceOf('Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer', $transformer);
		$this->assertEquals('column', $transformer->getOption('path'));
		$this->assertEquals(true, $transformer->getOption('required'));
		$this->assertEquals('', $transformer->getOption('empty_value'));
	}
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolverInterface')->getMock();
		$optionsResolver
			->expects($this->once())
			->method('setDefaults')
			->with(array(
				'path' => null,
				'required' => true,
				'empty_value' => ''
			))
			->will($this->returnValue($optionsResolver))
		;
		$optionsResolver
			->expects($this->once())
			->method('setAllowedTypes')
			->with(array(
				'path' => 'string',
				'required' => 'bool',
				'empty_value' => 'string'
			))
			->will($this->returnValue($optionsResolver))
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
