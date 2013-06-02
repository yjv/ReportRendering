<?php
namespace Yjv\ReportRendering\Event;

use Yjv\ReportRendering\ReportData\DataInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

class FilterDataEvent extends DataEvent
{
    protected $data;

    public function __construct(
        $rendererName, 
        RendererInterface $renderer,
        DatasourceInterface $datasource, 
        FilterCollectionInterface $filters,
        DataInterface $data
    ) {
        
        parent::__construct($rendererName, $renderer, $datasource, $filters);
        $this->data = $data;
    }

    /**
     * 
     * @return null|DataInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 
     * @param ImmutableDataInterface $data
     * @return \Yjv\ReportRendering\Event\FilterDataEvent
     */
    public function setData(ImmutableDataInterface $data)
    {
        $this->data = $data;
        return $this;
    }
}
