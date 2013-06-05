<?php
namespace Yjv\ReportRendering\Renderer;

class ValidRendererNotReturnedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('No valid renderer was returned from the builder\'s constructor callback.');
    }
}
