<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\ReportData\ReportData;

class FakeDatasource implements DatasourceInterface
{

    public function getData(array $filters)
    {
        $data = array(array('hello' => 'goodbye'), array('hello' => 'goodbye'),
            array('hello' => 'goodbye'), array('hello' => 'goodbye'),
            array('hello' => 'goodbye'), array('hello' => 'goodbye'),);

        return new ReportData($data, 100);
    }
}
