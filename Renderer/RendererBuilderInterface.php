<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

interface RendererBuilderInterface extends BuilderInterface
{
    public function getRenderer();
    public function setConstructor($callback);
}
