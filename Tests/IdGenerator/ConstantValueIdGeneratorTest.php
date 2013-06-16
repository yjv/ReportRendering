<?php
namespace Yjv\ReportRendering\Tests\IdGenerator;

use Yjv\ReportRendering\IdGenerator\ConstantValueIdGenerator;

use Mockery;

class ConstantValueIdGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected $generator;
    
    public function setUp()
    {
        $this->generator = new ConstantValueIdGenerator('id');
    }
    
    public function testGetId()
    {
        $this->assertEquals('id', $this->generator->getId(Mockery::mock('Yjv\ReportRendering\Report\ReportInterface')));
    }
}
