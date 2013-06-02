<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;

use Yjv\ReportRendering\DataTransformer\MappedDataTransformer;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;

class MappedDataTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $data;
	
	public function setUp(){
	
		$this->transformer = new MappedDataTransformer();
		$this->transformer->setConfig(array());
		$this->data = 'John';
	}
	
	/**
	 * @expectedException Yjv\ReportRendering\DataTransformer\Config\ConfigValueRequiredException
	 */
	public function testMissingRequiredOptions(){
	
		$this->transformer->transform($this->data, $this->data);
	}
	
	public function testMappedDataTranform() {
		
		$this->transformer->setConfig(array('map' => array('John' => 'Smith')));
		$this->assertEquals('Smith', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setConfig(array(
				'empty_value' => 'Last Name Unknown',
				'map' => array('Joe' => 'Smith'),
				'required' => false
		));
		
		$this->assertEquals('Last Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() {
		
		$this->transformer->setConfig(array(
				'map' => array('Joe' => 'Smith')
		));
		
		$this->setExpectedException('InvalidArgumentException');
		$this->transformer->transform($this->data, $this->data);
	}
}