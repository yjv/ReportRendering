<?php
namespace Yjv\ReportRendering\Renderer;

interface ResponseAwareRendererInterface extends RendererInterface
{
    public function renderResponse(array $options = array());
}
