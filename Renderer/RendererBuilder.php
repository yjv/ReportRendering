<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Factory\Builder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

class RendererBuilder extends Builder implements RendererBuilderInterface
{
    protected $callback;

    public function getRenderer()
    {
        $constructor = $this->callback;
        return $constructor($this);
    }

    public function setConstructor($callback)
    {
        $this->callback = $callback;
        return $this;
    }
}