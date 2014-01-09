<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaper;
use Mockery;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\Form\Util\PropertyPath;

use Symfony\Component\Form\Exception\PropertyAccessDeniedException;

use Symfony\Component\Form\Exception\InvalidPropertyException;

use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;

class PropertyPathTransformerTest extends \PHPUnit_Framework_TestCase
{
	protected $transformer;
	protected $data;
	
	public function setUp()
	{
	
		$this->transformer = new PropertyPathTransformer();
		$this->transformer->setConfig(array());
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	/**
	 * @expectedException Yjv\ReportRendering\DataTransformer\Config\ConfigValueRequiredException
	 */
	public function testMissingRequiredOptions()
	{
		$this->transformer->transform($this->data, $this->data);
	}
	
	public function testPropertyPathTranform() 
	{
		$this->transformer->setConfig(array('path' => '[firstName]'));
		$this->assertEquals('John', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound()
	{
		$this->transformer->setConfig(array(
				'empty_value' => 'First Name Unknown',
				'path' => 'name',
				'required' => false
		));
		
		$this->assertEquals('First Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() 
	{
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
	
	public function testEscapingOfPath()
	{
	    $escaper = new DataEscaper();
	    $this->transformer->setConfig(array(
				'path' => '[name]'
		));
	    $this->assertEquals($escaper->escape('<h1></h1>'), $this->transformer->transform(array('name' => '<h1></h1>'), array()));
	    $this->transformer->setConfig(array(
				'path' => '[name]',
	            'escape_value' => false
		));
	    $this->assertEquals('<h1></h1>', $this->transformer->transform(array('name' => '<h1></h1>'), array()));
	}
	
	public function testEscapePathStrategy()
	{
	    $escaper = Mockery::mock('Yjv\ReportRendering\Data\DataEscaperInterface');
	    $transformer = new PropertyPathTransformer(null, $escaper);
	    $transformer->setConfig(array('path' => '[firstName]'));
	    $escaper
	        ->shouldReceive('escape')
	        ->once()
	        ->with('John', 'html')
	        ->andReturn('John2')
	    ;
	    $this->assertEquals('John2', $transformer->transform($this->data, $this->data));
	     
	    $transformer->setConfig(array(
				'path' => '[firstName]',
	            'escape_strategy' => 'html_attr'
		));
	    ;
        $escaper
            ->shouldReceive('escape')
            ->once()
            ->with('John', 'html_attr')
            ->andReturn('John2')
        ;
        $this->assertEquals('John2', $transformer->transform($this->data, $this->data));
	}
}

class DataWithHiddenProperty
{
	protected $name = 'sdsss';
}

