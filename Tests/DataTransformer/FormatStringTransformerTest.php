<?php
namespace Yjv\ReportRendering\Test\DataTransformer;


use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Yjv\ReportRendering\Tests\DataTransformer\AbstractDataTransformerTest;
use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;
use Mockery;
use Yjv\ReportRendering\Tests\DataTransformer\Fixtures\DataWithHiddenProperty;


class FormatStringTransformerTest extends AbstractDataTransformerTest
{
    protected $transaformerData;

    public function setUp()
    {
		$this->transformer = new FormatStringTransformer('{[firstName]} {[lastName]}');
		$this->transaformerData = array('firstName' => 'John', 'lastName' => 'Smith');
	}
	
	public function testFormatStringTransform()
    {
        $this->assertEquals('John Smith', $this->transformer->transform($this->transaformerData, array()));
	}
	
	public function testDefaultValueOnNotFound()
    {
		$this->transformer = new FormatStringTransformer('{name}', false, 'Name Unknown');
		$this->assertEquals('Name Unknown', $this->transformer->transform($this->transaformerData, array()));
	}

	public function testExceptionOnNotFound()
    {
		$this->transformer = new FormatStringTransformer('{name}');
	
		try {
				
			$this->transformer->transform($this->transaformerData, array());
			$this->fail('did not throw exception on path not found');
		} catch (ExceptionInterface $e) {
		}
	
		try {
				
			$this->transformer->transform(new DataWithHiddenProperty(), array());
			$this->fail('did not throw exception on path not found');
		} catch (ExceptionInterface $e) {
		}
	}	
	
	public function testEscapingOfPaths()
	{
	    $escaper = Mockery::mock('Yjv\ReportRendering\Data\DataEscaperInterface');
	    $decider = Mockery::mock('Yjv\ReportRendering\Data\StrategyDeciderInterface');
	    $this->transformer = new FormatStringTransformer('{[firstName]} {[lastName]}');
        $this->transformer
            ->setEscaper($escaper)
            ->setEscapeStrategyDecider($decider)
        ;
        $data = array(
            'firstName' => '<h1></h1>',
            'lastName' => '<span></span>'
        );
        $decider
            ->shouldReceive('getStrategy')
            ->once()
            ->with('[firstName]', $data['firstName'])
            ->andReturn('strategy1')
            ->getMock()
            ->shouldReceive('getStrategy')
            ->once()
            ->with('[lastName]', $data['lastName'])
            ->andReturn('strategy2')
            ->getMock()
        ;
        $escaper
            ->shouldReceive('escape')
            ->once()
            ->with($data['firstName'], 'strategy1')
            ->andReturn('escaped1')
            ->getMock()
            ->shouldReceive('escape')
            ->once()
            ->with($data['lastName'], 'strategy2')
            ->andReturn('escaped2')
            ->getMock()
        ;
	    $this->assertEquals('escaped1 escaped2', $this->transformer->transform(array(
            'firstName' => '<h1></h1>', 
            'lastName' => '<span></span>'
        ), array()));
	}
}