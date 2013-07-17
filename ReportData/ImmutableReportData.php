<?php
namespace Yjv\ReportRendering\ReportData;

class ImmutableReportData implements ImmutableDataInterface
{
    protected $data;
    protected $unpaginatedCount;

    /**
     * 
     * @param ImmutableDataInterface $data
     * @return \Yjv\ReportRendering\ReportData\ImmutableReportData
     */
    public static function createFromData(ImmutableDataInterface $data)
    {
        return new static($data->getData(), $data->getUnpaginatedCount());
    }

    public function __construct($data, $unpaginatedCount)
    {
        if (!is_array($data) && !$data instanceof \Countable) {

            throw new \InvalidArgumentException('$data must be an array or an instance of Countable');
        }

        $this->data = $data;
        $this->unpaginatedCount = $unpaginatedCount;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getUnpaginatedCount()
    {
        return $this->unpaginatedCount;
    }

    public function getCount()
    {
        return count($this->data);
    }
}
