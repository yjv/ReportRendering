<?php
namespace Yjv\ReportRendering\Event;

use Symfony\Component\EventDispatcher\Event;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

class DataEvent extends Event
{
    protected $data;
    protected $datasource;
    protected $filters;
    protected $renderer;
    protected $rendererName;

    public function __construct(
        $rendererName, 
        RendererInterface $renderer, 
        DatasourceInterface $datasource, 
        FilterCollectionInterface $filters
    ) {
        $this->rendererName = $rendererName;
        $this->renderer = $renderer;
        $this->datasource = $datasource;
        $this->filters = $filters;
    }

    /**
     * 
     * @return DatasourceInterface
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * 
     * @return FilterCollectionInterface
     */
    public function getFilters()
    {
        return $this->filters;
    }
    
    public function setFilters(FilterCollectionInterface $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public function getRendererName()
    {
        return $this->rendererName;
    }
}
