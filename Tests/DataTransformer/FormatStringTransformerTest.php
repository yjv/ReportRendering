<?php
namespace Yjv\ReportRendering\Test\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaper;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Yjv\ReportRendering\Tests\DataTransformer\DataWithHiddenProperty;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;
use Mockery;


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
	
	public function testEscapingOfPaths()
	{
	    $escaper = new DataEscaper();
	    $this->transformer->setConfig(array(
				'format_string' => '{[firstName]} {[lastName]}'
		));
	    $this->assertEquals($escaper->escape('<h1></h1> <span></span>'), $this->transformer->transform(array(
            'firstName' => '<h1></h1>', 
            'lastName' => '<span></span>'
        ), array()));
	    $this->transformer->setConfig(array(
				'format_string' => '{[firstName]} {[lastName]}',
	            'escape_values' => false
		));
	    $this->assertEquals('<h1></h1> <span></span>', $this->transformer->transform(array(
            'firstName' => '<h1></h1>', 
            'lastName' => '<span></span>'
        ), array()));
	}
	
	public function testEscapePathStrategies()
	{
	    $escaper = Mockery::mock('Yjv\ReportRendering\Data\DataEscaperInterface');
	    $transformer = new FormatStringTransformer(null, $escaper);
	    $transformer->setConfig(array(
            'format_string' => '{[firstName]} {[lastName]}',
            'escape_strategies' => array(
                '[lastName]' => 'html_attr'
            )
        ));
	    $escaper
	        ->shouldReceive('escape')
	        ->once()
	        ->with('John', 'html')
	        ->andReturn('John2')
	        ->getMock()
	        ->shouldReceive('escape')
	        ->once()
	        ->with('Smith', 'html_attr')
	        ->andReturn('Smith2')
	        ->getMock()
	    ;
	    $this->assertEquals('John2 Smith2', $transformer->transform($this->data, $this->data));
	     
	    $transformer->setConfig(array(
			'format_string' => '{[firstName]} {[lastName]}',
            'escape_strategies' => array(
                '[lastName]' => false
            )
		));
	    ;
        $escaper
            ->shouldReceive('escape')
            ->once()
            ->with('John', 'html')
            ->andReturn('John2')
        ;
        $this->assertEquals('John2 Smith', $transformer->transform($this->data, $this->data));
	}
}