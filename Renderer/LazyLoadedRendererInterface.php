<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

interface LazyLoadedRendererInterface extends RendererInterface
{
    public function getRenderer();
}
