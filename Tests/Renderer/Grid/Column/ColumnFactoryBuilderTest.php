<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;

use Mockery;

class ColumnFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = new ColumnFactoryBuilder();
    }
    
    public function testBuild()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory', $this->builder->build());
    }
}
