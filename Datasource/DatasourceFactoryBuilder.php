<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension;
use Yjv\TypeFactory\TypeFactoryBuilder;

class DatasourceFactoryBuilder extends TypeFactoryBuilder
{
    protected function getFactoryInstance()
    {
        return new DatasourceFactory(
            $this->getTypeResolver(),
            $this->getBuilderInterfaceName()
        );
    }

    protected function getDefaultExtensions()
    {
        return array(new CoreExtension());
    }

    protected function getDefaultBuilderInterfaceName()
    {
        return BuilderInterfaces::DATASOURCE;
    }

}
