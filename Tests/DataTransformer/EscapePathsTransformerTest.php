<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\EscapePathsTransformer;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DateTimeTransformer;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\PropertyPathTransformer;

class EscapePathsTransformerTest extends \PHPUnit_Framework_TestCase{

	protected $transformer;
	protected $escaper;
	
	public function setUp(){
	
		$this->escaper = $this->getMock('Yjv\Bundle\ReportRenderingBundle\Data\DataEscaperInterface');
		$this->escaper->expects($this->any())->method('getSupportedStrategies')->will($this->returnValue(array(
				'js',
				'css',
				'html_attr',
				'html',
				'url'
		)));
		$this->transformer = new EscapePathsTransformer($this->escaper);
	}
	
	public function testTransform(){
		
		$data = array('path1' => 'hello', 'path2' => 'goodbye');
		
		$this->escaper->expects($this->once())->method('escape')->with('js', 'hello')->will($this->returnValue('goodbye'));
		$this->transformer->setOptions(array('paths' => array('[path1]' => array('escape_strategy' => 'js'))));
		$this->assertEquals(array('path1' => 'goodbye', 'path2' => 'goodbye'), $this->transformer->transform($data, $data));
	}
	
	public function testTransformWithObject() {
		
		$data = new \stdClass();
		$data->path1 = 'hello';
		$data->path2 = 'goodbye';
		
		$this->escaper->expects($this->once())->method('escape')->with('js', 'hello')->will($this->returnValue('goodbye'));
		$this->transformer->setOptions(array('paths' => array('path1' => array('escape_strategy' => 'js'))));
		$transformedData = $this->transformer->transform($data, $data);
		$this->assertTrue($data === $transformedData);
		$this->assertEquals('goodbye', $transformedData->path1);
	}
	
	public function testTransformWithObjectAndCopy() {
		
		$data = new \stdClass();
		$data->path1 = 'hello';
		$data->path2 = 'goodbye';
		
		$this->escaper->expects($this->once())->method('escape')->with('js', 'hello')->will($this->returnValue('goodbye'));
		$this->transformer->setOptions(array('copy_before_escape' => true, 'paths' => array('path1' => array('escape_strategy' => 'js'))));
		$transformedData = $this->transformer->transform($data, $data);
		$this->assertNotSame($data, $transformedData);
		$this->assertEquals('goodbye', $transformedData->path1);
	}
}
