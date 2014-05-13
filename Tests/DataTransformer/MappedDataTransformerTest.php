<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;


use Yjv\ReportRendering\DataTransformer\MappedDataTransformer;

class MappedDataTransformerTest extends AbstractDataTransformerTest
{
	protected $transformer;
    protected $transformerData;

    public function setUp(){
	
		$this->transformer = new MappedDataTransformer(array('John' => 'Smith'));
		$this->transformerData = 'John';
	}
	
	public function testMappedDataTranform()
    {
		$this->assertEquals('Smith', $this->transformer->transform($this->transformerData, array()));
	}
	
	public function testDefaultValueOnNotFound()
    {
		$this->transformer = new MappedDataTransformer(array('Joe' => 'Smith'), false, 'Last Name Unknown');;
		$this->assertEquals('Last Name Unknown', $this->transformer->transform($this->transformerData, array()));
	}

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionOnNotFound()
    {
		$this->transformer->transform('Joe', array());
	}
}