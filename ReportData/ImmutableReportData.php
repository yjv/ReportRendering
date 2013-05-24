<?php
namespace Yjv\Bundle\ReportRenderingBundle\ReportData;

class ImmutableReportData implements ImmutableDataInterface
{
    protected $data;
    protected $unFilteredCount;

    /**
     * 
     * @param ImmutableDataInterface $data
     * @return \Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData
     */
    public static function createFromData(ImmutableDataInterface $data)
    {
        return new static($data->getData(), $data->getUnfilteredCount());
    }

    public function __construct($data, $unFilteredCount)
    {
        if (!is_array($data) && !$data instanceof \Countable) {

            throw new \InvalidArgumentException('$data must be an array or an instance of Countable');
        }

        $this->data = $data;
        $this->unFilteredCount = $unFilteredCount;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getUnfilteredCount()
    {
        return $this->unFilteredCount;
    }

    public function getCount()
    {
        return count($this->data);
    }
}
