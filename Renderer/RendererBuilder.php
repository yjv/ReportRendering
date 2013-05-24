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
    protected $rendererFactory;

    public function __construct(RendererFactoryInterface $rendererFactory)
    {
        $this->rendererFactory = $rendererFactory;
    }

    public function getRenderer()
    {
        $constructor = $this->callback;
        return $constructor($this);
    }

    public function getRendererFactory()
    {
        return $this->rendererFactory;
    }

    public function setConstructor($callback)
    {
        $this->callback = $callback;
        return $this;
    }
}