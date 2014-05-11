<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;
use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;
use Yjv\TypeFactory\TypeFactory;
use Yjv\TypeFactory\TypeFactoryBuilder;

class ColumnFactoryBuilder extends TypeFactoryBuilder
{
    protected function getDefaultBuilderInterfaceName()
    {
        return BuilderInterfaces::COLUMN;
    }

    protected function getDefaultExtensions()
    {
        return array(new CoreExtension());
    }

    protected function getFactoryInstance()
    {
        return new ColumnFactory(
            $this->getTypeResolver(),
            $this->getBuilderInterfaceName()
        );
    }
}
