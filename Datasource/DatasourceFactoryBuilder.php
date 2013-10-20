<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceFactory;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Factory\AbstractTypeFactoryBuilder;

class DatasourceFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected function getFactoryInstance()
    {
        return new DatasourceFactory($this->getTypeResolver());
    }
}
