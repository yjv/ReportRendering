<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config;

interface ConfigInterface
{
    public function get($name, $default = null);
}
