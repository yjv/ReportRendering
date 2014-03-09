<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\AbstractDatasourceType;

class DatasourceType extends AbstractDatasourceType
{
    /**
     * 
     */
    public function getName()
    {
        return 'datasource';
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return false;
    }
}
