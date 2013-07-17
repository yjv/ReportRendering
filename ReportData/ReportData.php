<?php
namespace Yjv\ReportRendering\ReportData;

class ReportData extends ImmutableReportData implements DataInterface
{
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setUnpaginatedCount($unpaginatedCount)
    {
        $this->unpaginatedCount = $unpaginatedCount;
        return $this;
    }
}
