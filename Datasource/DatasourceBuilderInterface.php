<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\TypeFactory\BuilderInterface;

interface DatasourceBuilderInterface extends BuilderInterface
{
    public function getDatasource();
}
