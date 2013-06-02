<?php
namespace Yjv\ReportRendering\Test\DataTransformer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Yjv\ReportRendering\Tests\DataTransformer\DataWithHiddenProperty;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;


class FormatStringTransformerTest extends \PHPUnit_Framework_TestCase{

	public function setUp(){
		
		$this->transformer = new FormatStringTransformer();
		$this->transformer->setConfig(array());
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	/**
	 * @expectedException Yjv\ReportRendering\DataTransformer\Config\ConfigValueRequiredException
	 */
	public function testMissingRequiredOptions(){
		
		$this->transformer->transform($this->data, $this->data);
	}
	
	public function testFormatStringTranform() {
		
		$this->transformer->setConfig(array('format_string' => '{[firstName]} {[lastName]}'));
		$this->assertEquals('John Smith', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setConfig(array(
				'empty_value' => 'Name Unknown',
				'format_string' => '{name}',
				'required' => false
		));
		
		$this->assertEquals('Name Unknown', $this->transformer->transform($this->data, $this->data));
	}

	public function testExceptionOnNotFound() {
	
		$this->transformer->setConfig(array(
			'format_string' => '{name}',
		));
	
		try {
				
			$this->transformer->transform($this->data, $this->data);
			$this->fail('did not throw exception on path not found');
		} catch (ExceptionInterface $e) {
		}
	
		try {
				
			$this->transformer->transform(new DataWithHiddenProperty(), $this->data);
			$this->fail('did not throw exception on path not found');
		} catch (ExceptionInterface $e) {
		}
	}
	
}