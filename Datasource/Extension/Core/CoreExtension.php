<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\CallbackType;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\ArrayType;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\DatasourceType;

use Yjv\TypeFactory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    public function loadTypes()
    {
        return array(

            new DatasourceType(),
            new ArrayType(),
            new CallbackType()
        );
    }
}
