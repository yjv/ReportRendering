<?php
namespace Yjv\Bundle\ReportRenderingBundle\Test\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\FormatStringTransformer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormatStringTransformerTest extends WebTestCase{

	public function setUp(){
		
		$this->transformer = new FormatStringTransformer();
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	public function testMissingRequiredOptions(){
		
		try {
			$this->transformer->transform($this->data, $this->data);
			$this->fail('transform failed to throw an exception');
		} catch (\Exception $e) {

			$this->assertInstanceOf('Symfony\\Component\\OptionsResolver\\Exception\\MissingOptionsException', $e);
		}
	}
	
	public function testFormatStringTranform() {
		
		$this->transformer->setOptions(array('format_string' => '{[firstName]} {[lastName]}'));
		$this->assertEquals('John Smith', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setOptions(array(
				'empty_value' => 'Name Unknown',
				'format_string' => '{name}',
				'required' => false
		));
		
		$this->assertEquals('Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
}
