<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

interface RendererFactoryInterface extends TypeFactoryInterface
{
    public function getColumnFactory();
}
