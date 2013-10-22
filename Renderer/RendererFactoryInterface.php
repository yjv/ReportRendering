<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\TypeFactory\TypeFactoryInterface;

interface RendererFactoryInterface extends TypeFactoryInterface
{
    public function getColumnFactory();
}
