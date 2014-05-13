<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;


use Mockery;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;
use Yjv\ReportRendering\Tests\DataTransformer\Fixtures\DataWithHiddenProperty;

class PropertyPathTransformerTest extends \PHPUnit_Framework_TestCase
{
	protected $transformer;
	protected $data;
	
	public function setUp()
	{
		$this->transformer = new PropertyPathTransformer('[firstName]');
		$this->data = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	public function testPropertyPathTranform() 
	{
		$this->assertEquals('John', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testDefaultValueOnNotFound()
	{
		$this->transformer = new PropertyPathTransformer('name', false, 'First Name Unknown');
		$this->assertEquals('First Name Unknown', $this->transformer->transform($this->data, $this->data));
	}
	
	public function testExceptionOnNotFound() 
	{
		$this->transformer = new PropertyPathTransformer('name');
		
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
        $escaper = Mockery::mock('Yjv\ReportRendering\Data\DataEscaperInterface');
        $decider = Mockery::mock('Yjv\ReportRendering\Data\StrategyDeciderInterface');
	    $this->transformer = new PropertyPathTransformer('[name]');
        $this->transformer
            ->setEscaper($escaper)
            ->setEscapeStrategyDecider($decider)
        ;
        $data = array('name' => '<h1></h1>');
        $decider
            ->shouldReceive('getStrategy')
            ->once()
            ->with('[name]', $data['name'])
            ->andReturn('strategy1')
            ->getMock()
        ;
        $escaper
            ->shouldReceive('escape')
            ->once()
            ->with($data['name'], 'strategy1')
            ->andReturn('escaped1')
            ->getMock()
        ;
	    $this->assertEquals('escaped1', $this->transformer->transform($data, array()));
	}
}