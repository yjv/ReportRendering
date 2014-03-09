<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\TypeFactory\Builder;

abstract class AbstractRendererBuilder extends Builder implements RendererBuilderInterface
{
    protected $grid;

    public function setGrid(GridInterface $grid)
    {
        $this->grid = $grid;
        return $this;
    }
    
    public function getGrid()
    {
        if (!$this->grid) {
            
            $this->grid = $this->getDefaultGrid();
        }
        
        return $this->grid;
    }
    
    public function addColumn($column, array $options = array())
    {
        $this->getGrid()->addColumn($this->normalizeColumn($column, $options));
        return $this;
    }
    
    protected function normalizeColumn($column, array $options)
    {
        if (!$column instanceof ColumnInterface) {
            
            $column = $this->factory->getColumnFactory()->create($column, $options);
        }
        
        return $column;
    }
    
    protected function getDefaultGrid()
    {
        return new Grid();
    }
}