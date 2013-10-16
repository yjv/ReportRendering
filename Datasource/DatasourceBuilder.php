<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceInterface;

use Yjv\ReportRendering\Factory\VariableConstructorBuilder;

class DatasourceBuilder extends VariableConstructorBuilder implements DatasourceBuilderInterface
{
    public function getDatasource()
    {
        $constructor = $this->callback;
        $datasource = call_user_func($constructor, $this);
        
        if (!$datasource instanceof DatasourceInterface) {
            
            throw new ValidDatasourceNotReturnedException();
        }
        
        return $datasource;
    }
}