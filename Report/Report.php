<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Filter\MultiReportFilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\IdGenerator\CallCountIdGenerator;

use Yjv\Bundle\ReportRenderingBundle\IdGenerator\IdGeneratorInterface;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Yjv\Bundle\ReportRenderingBundle\Event\FilterDataEvent;

use Yjv\Bundle\ReportRenderingBundle\Event\DataEvent;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData;

use Yjv\Bundle\ReportRenderingBundle\Renderer\FilterAwareRendererInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

/**
 * 
 * @author yosefderay
 *
 */
class Report implements ReportInterface{

	protected $datasource;
	protected $renderers = array();
	protected $filters;
	protected $eventDispatcher;
	protected $idGenerator;
	protected $id;

	public function __construct(DatasourceInterface $datasource, RendererInterface $defaultRenderer, EventDispatcherInterface $eventDispatcher) {

		$this->datasource = $datasource;
		$this->addRenderer('default', $defaultRenderer);
		$this->eventDispatcher = $eventDispatcher;
		$this->filters = new NullFilterCollection();
		$this->idGenerator = new CallCountIdGenerator();
	}

	/**
	 * 
	 * @param string $name
	 * @param RendererInterface $renderer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function addRenderer($name, RendererInterface $renderer) {

		$this->renderers[$name] = $renderer;
		return $this;
	}

	/**
	 * 
	 * @param string $name
	 * @throws RendererNotFoundException
	 * @return RendererInterface
	 */
	public function getRenderer($name = 'default') {

		if (!isset($this->renderers[$name])) {

			throw new RendererNotFoundException($name);
		}

		$renderer = $this->renderers[$name];
		
		$renderer->setReportId($this->getId());
		
		if ($renderer instanceof FilterAwareRendererInterface) {
			
			$renderer->setFilters($this->getFilters());
		}
		
		$renderer->setData($this->getData($name, $renderer));
		
		return $renderer;
	}
	
	/**
	 * @return array
	 */
	public function getRenderers() {
	
		return $this->renderers;
	}
	
	/**
	 * 
	 * @param string $name
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function removeRenderer($name) {
		
		unset($this->renderers[$name]);
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $eventName
	 * @param callable $listener
	 * @param number $priority
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function addEventListener($eventName, $listener, $priority = 0) {

		$this->eventDispatcher->addListener($eventName, $listener, $priority);
		return $this;
	}

	/**
	 * 
	 * @param EventSubscriberInterface $eventSubscriber
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function addEventSubscriber(EventSubscriberInterface $subscriber) {

		$this->eventDispatcher->addSubscriber($subscriber);
		return $this;
	}

	/**
	 * 
	 * @return mixed the data returned from the datasoucre filtered by the post load listeners
	 */
	public function getData($rendererName, RendererInterface $renderer) {

		$dataEvent = new DataEvent($rendererName, $renderer, $this->datasource, $this->filters);
		$this->eventDispatcher->dispatch(ReportEvents::PRE_LOAD_DATA, $dataEvent);
		
		$this->datasource->setFilters($dataEvent->getFilters());
		$data = $this->datasource->getData($renderer->getForceReload());
		$dataEvent = new FilterDataEvent($rendererName, $renderer, $this->datasource, $this->filters, $data);
		
		$this->eventDispatcher->dispatch(ReportEvents::POST_LOAD_DATA, $dataEvent);
		return $this->lockData($dataEvent->getData());
	}

	/**
	 * @return DatasourceInterface
	 */
	public function getDatasource() {
		
		return $this->datasource;
	}

	/**
	 * 
	 * @param DatasourceInterface $datasource
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function setDatasource(DatasourceInterface $datasource) {
		
		$this->datasource = $datasource;
		return $this;
	}

	/**
	 * @return FilterCollectionInterface
	 */
	public function getFilters() {
		
		return $this->filters;
	}

	/**
	 * 
	 * @param FilterCollectionInterface $filters
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function setFilters(FilterCollectionInterface $filters) {
		
		if ($filters instanceof MultiReportFilterCollectionInterface) {
			
			$filters->setReportId($this->getId());
		}
		
		$this->filters = $filters;
		
		return $this;
	}

	/**
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher() {
		
		return $this->eventDispatcher;
	}

	/**
	 * 
	 * @param EventDispatcherInterface $eventDispatcher
	 * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
	 */
	public function setEventDispatcher(EventDispatcherInterface $eventDispatcher) {
		
		$this->eventDispatcher = $eventDispatcher;
		return $this;
	}
	
	public function getId() {
		
		$this->generateId();
		return $this->id;
	}
	
	public function setIdGenerator(IdGeneratorInterface $idGenerator) {
		
		$this->idGenerator = $idGenerator;
		return $this;
	}

	/**
	 * 
	 * @param ImmutableDataInterface $data
	 * @return \Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData
	 */
	protected function lockData(ImmutableDataInterface $data) {
		
		return ImmutableReportData::createFromData($data);
	}
	
	protected function generateId() {
		
		if (empty($this->id)) {
			
			$this->id = $this->idGenerator->getId($this);
		}
		
		return $this;
	}
}
