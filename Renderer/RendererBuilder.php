<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Factory\Builder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererTypeDelegateInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;
use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

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