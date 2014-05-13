<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;


use Yjv\ReportRendering\DataTransformer\DateTimeTransformer;

class DateTimeTransformerTest extends AbstractDataTransformerTest
{
    /** @var  DateTimeTransformer */
    protected $transformer;
	protected $data;
    protected $dateString;
    protected $format;

    public function setUp()
    {
        $this->format = 'Y-m-d';
        $this->transformer = new DateTimeTransformer($this->format);
        $this->data = array('firstName' => 'John', 'lastName' => 'Smith');
        $this->dateString = '+1 year';
	}
	
	public function testDateTranform()
    {
		$dateTime = new \DateTime($this->dateString);
		$this->assertEquals($dateTime->format($this->format), $this->transformer->transform($this->dateString, array()));
	}
	
	public function testInvalidData()
    {

        try {
			
			$this->transformer->transform('sgdsgd', array());
			$this->fail('no exception thrown on invalid date string');
		} catch (\InvalidArgumentException $e) {
            $this->assertEquals('$data must be an instance of DateTime, a valid date string or an integer timestamp', $e->getMessage());
		}
		
		try {
			
			$this->transformer->transform(new \stdClass(), array());
			$this->fail('no excpetion thrown on invalid data type');
		} catch (\InvalidArgumentException $e) {
            $this->assertEquals('$data must be an instance of DateTime, a valid date string or an integer timestamp', $e->getMessage());
		}
	}
}
