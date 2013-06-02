<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererTypeDelegateInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;
use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

interface RendererBuilderInterface extends BuilderInterface
{
    public function getRenderer();
    public function setConstructor($callback);
}
