<?php
namespace Yjv\ReportRendering\DataTransformer\Config;

interface ConfigInterface
{
    public function get($name, $default = null);
}
