<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\VariableConstructorBuilderInterface;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

interface RendererBuilderInterface extends VariableConstructorBuilderInterface
{
    public function getRenderer();
    public function setGrid(GridInterface $grid);
    public function getGrid();
    public function addColumn($column, array $options = array());
}
