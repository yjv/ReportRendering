<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceFactory;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Factory\AbstractFactoryBuilder;

class DatasourceFactoryBuilder extends AbstractFactoryBuilder
{
    protected function getFactoryInstance()
    {
        return new DatasourceFactory($this->getTypeResolver());
    }
}
