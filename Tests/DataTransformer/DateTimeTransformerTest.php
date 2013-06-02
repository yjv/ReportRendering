<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DateTimeTransformer;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

class DateTimeTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $data;
	
	public function setUp(){
	
		$this->transformer = new DateTimeTransformer();
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
		$this->dateString = '+1 year';
		$this->format = 'Y-m-d';
	}
	
	public function testDateTranform() {
		
		$dateTime = new \DateTime($this->dateString);
		$this->transformer->setConfig(array('format' => $this->format));
		$this->assertEquals($dateTime->format($this->format), $this->transformer->transform($this->dateString, array()));
	}
	
	public function testInvalidData() {
		
		$this->transformer->setConfig(array('format' => $this->format));
		
		try {
			
			$this->transformer->transform('sgdsgd', array());
			$this->fail('no exception thrown on invalid date string');
		} catch (\Exception $e) {
		}
		
		try {
			
			$this->transformer->transform(new \stdClass(), array());
			$this->fail('no excpetion thrown on invalid data type');
		} catch (\Exception $e) {
		}
	}
}
