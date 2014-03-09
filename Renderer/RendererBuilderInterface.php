<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\VariableConstructorBuilderInterface;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;
use Yjv\TypeFactory\BuilderInterface;

interface RendererBuilderInterface extends BuilderInterface
{
    public function getRenderer();
    public function setGrid(GridInterface $grid);
    public function getGrid();
    public function addColumn($column, array $options = array());
}
