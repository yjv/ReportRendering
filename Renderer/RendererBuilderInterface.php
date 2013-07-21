<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\ReportRendering\Factory\BuilderInterface;

interface RendererBuilderInterface extends BuilderInterface
{
    public function getRenderer();
    public function setConstructor($callback);
    public function getConstructor();
    public function setGrid(GridInterface $grid);
    public function getGrid();
}
