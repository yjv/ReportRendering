<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\FormatStringType;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\PropertyPathType;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\ColumnType;

use Yjv\TypeFactory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    public function loadTypes()
    {
        return array(
            new ColumnType(),
            new PropertyPathType(),
            new FormatStringType()
        );
    }
}
