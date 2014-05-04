<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;
use Yjv\TypeFactory\TypeFactory;

class ColumnFactory extends TypeFactory implements ColumnFactoryInterface
{
    public function getBuilderInterfaceName()
    {
        return 'Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface';
    }
}
