<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

interface ColumnFactoryInterface extends TypeFactoryInterface
{
    public function getDataTransformerRegistry();
}
