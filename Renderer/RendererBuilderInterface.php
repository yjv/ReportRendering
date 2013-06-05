<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

interface RendererBuilderInterface extends BuilderInterface
{
    public function getRenderer();
    public function setConstructor($callback);
    public function getConstructor();
    public function setGrid(GridInterface $grid);
    public function getGrid();
}
