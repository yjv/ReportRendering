<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceFactory;

use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

class DatasourceFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected function getFactoryInstance()
    {
        return new DatasourceFactory($this->getTypeResolver());
    }
}
