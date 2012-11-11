<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

class PropertyPathTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $data;
	
	public function setUp(){
	
		$this->transformer = new PropertyPathTransformer();
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	public function testMissingRequiredOptions(){
	
		try {
			$this->transformer->transform($this->data, $this->data);
			$this->fail('transform failed to throw an exception');
		} catch (MissingOptionsException $e) {
	
			$this->assertInstanceOf('Symfony\\Component\\OptionsResolver\\Exception\\MissingOptionsException', $e);
		}
	}
	
	public function testFormatStringTranform() {
		
		$this->transformer->setOptions(array('path' => '[firstName]'));
		$this->assertEquals('John', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setOptions(array(
				'empty_value' => 'First Name Unknown',
				'path' => 'name',
				'required' => false
		));
		
		$this->assertEquals('First Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() {
		
		$this->transformer->setOptions(array(
				'path' => 'name'
		));
		
		try {
			
			$this->transformer->transform($this->data, $this->data);
			$this->fail('did not throw exception on path not found');
		} catch (InvalidPropertyException $e) {
		}
	}
}
