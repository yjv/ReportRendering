<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

interface ColumnFactoryInterface extends TypeFactoryInterface
{
    public function getDataTransformerRegistry();
}
