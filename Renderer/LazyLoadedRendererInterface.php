<?php
namespace Yjv\ReportRendering\Renderer;

interface LazyLoadedRendererInterface extends RendererInterface
{
    public function getRenderer();
}
