<?php
namespace Yjv\ReportRendering\Widget;

interface WidgetRendererInterface
{
    public function render(WidgetInterface $widget, array $params = array());
}
