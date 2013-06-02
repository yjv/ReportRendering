<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\ReportData\ReportData;

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
