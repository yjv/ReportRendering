<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\MappedDataTransformer;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

class MappedDataTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $data;
	
	public function setUp(){
	
		$this->transformer = new MappedDataTransformer();
		$this->data = 'John';
	}
	
	public function testMissingRequiredOptions(){
	
		$this->setExpectedException('Symfony\Component\OptionsResolver\Exception\MissingOptionsException');
		$this->transformer->transform($this->data, $this->data);
	}
	
	public function testMappedDataTranform() {
		
		$this->transformer->setOptions(array('map' => array('John' => 'Smith')));
		$this->assertEquals('Smith', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setOptions(array(
				'empty_value' => 'Last Name Unknown',
				'map' => array('Joe' => 'Smith'),
				'required' => false
		));
		
		$this->assertEquals('Last Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() {
		
		$this->transformer->setOptions(array(
				'map' => array('Joe' => 'Smith')
		));
		
		$this->setExpectedException('InvalidArgumentException');
		$this->transformer->transform($this->data, $this->data);
	}
}