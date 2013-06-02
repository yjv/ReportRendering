<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\Form\Util\PropertyPath;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

class PropertyPathTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $data;
	
	public function setUp(){
	
		$this->transformer = new PropertyPathTransformer();
		$this->transformer->setConfig(array());
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	/**
	 * @expectedException Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\ConfigValueRequiredException
	 */
	public function testMissingRequiredOptions(){
	
		$this->transformer->transform($this->data, $this->data);
	}
	
	public function testPropertyPathTranform() {
		
		$this->transformer->setConfig(array('path' => '[firstName]'));
		$this->assertEquals('John', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound() {
		
		$this->transformer->setConfig(array(
				'empty_value' => 'First Name Unknown',
				'path' => 'name',
				'required' => false
		));
		
		$this->assertEquals('First Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() {
		
		$this->transformer->setConfig(array(
				'path' => 'name'
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

class DataWithHiddenProperty{

	protected $name = 'sdsss';
}

