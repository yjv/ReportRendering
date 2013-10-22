<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\VariableConstructorBuilder;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\TypeFactory\Builder;

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
        return $this->grid;
    }
}