<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\TypeFactory\TypeFactory;

class DatasourceFactory extends TypeFactory
{
    public function getBuilderInterfaceName()
    {
        return 'Yjv\ReportRendering\Datasource\DatasourceBuilderInterface';
    }
}
