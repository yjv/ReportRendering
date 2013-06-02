<?php
namespace Yjv\ReportRendering\DataTransformer\Config;

class ConfigValueRequiredException extends \Exception
{
    public function __construct($name)
    {
        parent::__construct( sprintf('The config option "%s" must be set.', $name));
    }
}
