<?php
namespace Yjv\ReportRendering\Tests\DataTransformer;

use Yjv\ReportRendering\Tests\DataTransformer\Fixtures\MockDataTransformer;

class AbstractDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockDataTransformer */
    protected $transformer;
    
    public function setUp()
    {
        $this->transformer = new MockDataTransformer();
    }
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Data\IdentityDataEscaper', $this->transformer->getEscaper());
        $escaper = \Mockery::mock('Yjv\ReportRendering\Data\DataEscaperInterface');
        $this->assertSame($this->transformer, $this->transformer->setEscaper($escaper));
        $this->assertSame($escaper, $this->transformer->getEscaper());
        $strategyDecider = \Mockery::mock('Yjv\ReportRendering\Data\StrategyDeciderInterface');
        $this->assertSame($this->transformer, $this->transformer->setEscapeStrategyDecider($strategyDecider));
        $this->assertSame($strategyDecider, $this->transformer->getEscapeStrategyDecider());
    }

    public function testTurningEscapingOnAndOff()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Data\IdentityDataEscaper', $this->transformer->getEscaper());
        $this->assertSame($this->transformer, $this->transformer->turnOnEscaping());
        $this->assertInstanceOf('Yjv\ReportRendering\Data\DefaultDataEscaper', $this->transformer->getEscaper());
        $this->assertSame($this->transformer, $this->transformer->turnOffEscaping());
        $this->assertInstanceOf('Yjv\ReportRendering\Data\IdentityDataEscaper', $this->transformer->getEscaper());
    }
}