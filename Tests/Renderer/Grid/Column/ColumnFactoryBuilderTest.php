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
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\DataTransformer\DataTransformerRegistry', $this->builder->getDataTransformerRegistry());
        $dataTransformerRegistry = Mockery::mock('Yjv\ReportRendering\DataTransformer\DataTransformerRegistry');
        $this->assertSame($this->builder, $this->builder->setDataTransformerRegistry($dataTransformerRegistry));
        $this->assertSame($dataTransformerRegistry, $this->builder->getDataTransformerRegistry());
    }
}
