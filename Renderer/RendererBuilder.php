<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\Factory\VariableConstructorBuilder;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\ReportRendering\Renderer\RendererInterface;

class RendererBuilder extends VariableConstructorBuilder implements RendererBuilderInterface
{
    protected $grid;

    public function getRenderer()
    {
        $constructor = $this->callback;
        $renderer = call_user_func($constructor, $this);
        
        if (!$renderer instanceof RendererInterface) {
            
            throw new ValidRendererNotReturnedException();
        }
        
        return $renderer;
    }
    
    public function setGrid(GridInterface $grid)
    {
        $this->grid = $grid;
        return $this;
    }
    
    public function getGrid()
    {
        if (!$this->grid) {
            
            $this->grid = new Grid();
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
}