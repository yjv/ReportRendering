<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\TypeFactory\AbstractTypeFactory;

class DatasourceFactory extends AbstractTypeFactory
{
    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getDatasource();
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\ReportRendering\Datasource\DatasourceBuilderInterface';
    }
}
