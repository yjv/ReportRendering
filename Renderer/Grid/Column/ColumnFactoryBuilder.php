<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;


use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;
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
