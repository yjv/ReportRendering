<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Renderer\RendererFactoryBuilder;

use Mockery;

class RendererFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = new RendererFactoryBuilder();
    }
    
    public function testBuild()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\RendererFactory', $this->builder->build());
    }
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder', $this->builder->getColumnFactoryBuilder());
        $columnFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setColumnFactoryBuilder($columnFactoryBuilder));
        $this->assertSame($columnFactoryBuilder, $this->builder->getColumnFactoryBuilder());
    }
}
