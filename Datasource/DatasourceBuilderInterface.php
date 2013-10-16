<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Factory\VariableConstructorBuilderInterface;

interface DatasourceBuilderInterface extends VariableConstructorBuilderInterface
{
    public function getDatasource();
}
