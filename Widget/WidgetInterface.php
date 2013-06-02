<?php
namespace Yjv\ReportRendering\Widget;

interface WidgetInterface
{
    public function setAttribute($name, $value);
    public function getAttributes();
    public function getAttribute($name, $default = null);
    public function getTemplate();
}
