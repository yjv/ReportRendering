<?php
namespace Yjv\ReportRendering\Event;

use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

class DataEvent extends RendererEvent
{
    protected $data;
    protected $datasource;
    protected $filterValues;

    public function __construct(
        ReportInterface $report,
        $rendererName,
        RendererInterface $renderer, 
        DatasourceInterface $datasource, 
        array $filterValues,
        ImmutableDataInterface $data = null
    ) {
        parent::__construct($report, $rendererName, $renderer);
        $this->datasource = $datasource;
        $this->filterValues = $filterValues;
        $this->data = $data;
    }

    /**
     * @return DatasourceInterface
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * @return array
     */
    public function getFilterValues()
    {
        return $this->filterValues;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilterValues(array $filters)
    {
        $this->filterValues = $filters;
        return $this;
    }

    /**
     * @return null|ImmutableDataInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param ImmutableDataInterface $data
     * @return $this
     */
    public function setData(ImmutableDataInterface $data)
    {
        $this->data = $data;
        return $this;
    }
}
