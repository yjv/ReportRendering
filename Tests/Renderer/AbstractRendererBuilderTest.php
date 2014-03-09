<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;

use Mockery;
use Yjv\ReportRendering\Renderer\Grid\Column\Column;
use Yjv\TypeFactory\Tests\BuilderTest;

abstract class AbstractRendererBuilderTest extends BuilderTest
{
    /**
     * @var AbstractRendererBuilder
     */
    protected $builder;

    /**
     * @var Mockery\MockInterface
     */
    protected $factory;

    /**
     * @var Mockery\MockInterface
     */
    protected $columnFactory;
    
    public function setUp()
    {
        $this->columnFactory = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface');
        $this->factory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface')
            ->shouldReceive('getColumnFactory')
            ->andReturn($this->columnFactory)
            ->getMock()
        ;
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

    abstract public function testGetRenderer();
}
