<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;
use Yjv\Bundle\ReportRenderingBundle\ReportData\ReportData;

class FakeDatasource implements DatasourceInterface
{

    public function getData($forceReload = false)
    {
        $data = array(array('hello' => 'goodbye'), array('hello' => 'goodbye'),
            array('hello' => 'goodbye'), array('hello' => 'goodbye'),
            array('hello' => 'goodbye'), array('hello' => 'goodbye'),);

        return new ReportData($data, 100);
    }

    public function setFilters(FilterCollectionInterface $filters)
    {
    }
}
