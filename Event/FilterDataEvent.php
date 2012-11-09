<?php
namespace Yjv\Bundle\ReportRenderingBundle\Event;

use Yjv\Bundle\ReportRenderingBundle\ReportData\DataInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

class FilterDataEvent extends DataEvent{

	protected $data;
	
	public function __construct($rendererName, RendererInterface $renderer, DatasourceInterface $datasource, FilterCollectionInterface $filters, DataInterface $data){
		
		parent::__construct($rendererName, $renderer, $datasource, $filters);
		$this->data = $data;
	}
	
	/**
	 * 
	 * @return null|DataInterface
	 */
	public function getData() {
		
		return $this->data;
	}
	
	/**
	 * 
	 * @param ImmutableDataInterface $data
	 * @return \Yjv\Bundle\ReportRenderingBundle\Event\FilterDataEvent
	 */
	public function setData(ImmutableDataInterface $data) {
		
		$this->data = $data;
		return $this;
	}
}
