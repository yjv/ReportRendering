<?php
namespace Yjv\Bundle\ReportRenderingBundle\Event;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

class DataEvent {

	protected $data;
	protected $datasource;
	protected $filters;
	protected $renderer;
	protected $rendererName;
	
	public function __construct($rendererName, RendererInterface $renderer, DatasourceInterface $datasource, FilterCollectionInterface $filters){
		
		$this->rendererName = $rendererName;
		$this->renderer = $renderer;
		$this->datasource = $datasource;
		$this->filters = $filters;
	}
	
	/**
	 * 
	 * @return DatasourceInterface
	 */
	public function getDatasource() {
		
		return $this->datasource;
	}
	
	/**
	 * 
	 * @return FilterCollectionInterface
	 */
	public function getFilters() {
		
		return $this->filters;
	}
	
	public function getRenderer() {
		
		return $this->renderer;
	}
	
	public function getRendererName() {
		
		return $this->rendererName;
	}
}
