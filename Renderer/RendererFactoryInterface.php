<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

interface RendererFactoryInterface extends TypeFactoryInterface
{
    public function getColumnFactory();
}
