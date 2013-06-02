<?php
namespace Yjv\ReportRendering\Renderer;

class RendererNotFoundException extends \Exception
{
    public function __construct($name)
    {
        parent::__construct(sprintf(
            'Renderer with the name "%s" has not been registered with this report',
            $name
        ));
    }
}
