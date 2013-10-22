<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Mockery;
use Yjv\ReportRendering\Renderer\Grid\Column\Column;

class RendererBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $factory;
    protected $columnFactory;
    
    public function setUp()
    {
        $this->columnFactory = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface');
        $this->factory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface')
            ->shouldReceive('getColumnFactory')
            ->andReturn($this->columnFactory)
            ->getMock()
        ;
        $this->builder = new RendererBuilder($this->factory);
    }
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\GridInterface', $this->builder->getGrid());
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $this->assertSame($this->builder, $this->builder->setGrid($grid));
        $this->assertSame($grid, $this->builder->getGrid());
    }
    
    public function testAddColumn()
    {
        $column1 = new Column();
        $column2 = new Column();
        $column2Name = 'column';
        $column2Options = array('key' => 'value');
        
        $this->columnFactory
            ->shouldReceive('create')
            ->once()
            ->with($column2Name, $column2Options)
            ->andReturn($column2)
        ;
        
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface')
            ->shouldReceive('addColumn')
            ->once()
            ->with($column1)
            ->getMock()            
            ->shouldReceive('addColumn')
            ->once()
            ->with($column2)
            ->getMock()
        ;
        
        $this->builder->setGrid($grid);
        $this->builder->addColumn($column1);
        $this->builder->addColumn($column2Name, $column2Options);
    }

    public function testGetRenderer()
    {
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        
        $callback = function() use ($renderer){
            
            return $renderer;
        };
        
        $this->builder->setConstructor($callback);
        $this->assertSame($renderer, $this->builder->getRenderer());
    }
    
    /**
     * @expectedException Yjv\ReportRendering\Renderer\ValidRendererNotReturnedException
     * @expectedExceptionMessage No valid renderer was returned from the builder's constructor callback.
     */
    public function testGetRendererWithInvalidRenderer()
    {
        $callback = function(){};
        $this->builder->setConstructor($callback);
        $this->builder->getRenderer();
    }
}
