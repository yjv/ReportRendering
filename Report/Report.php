<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Renderer\LazyLoadedRendererInterface;
use Yjv\ReportRendering\Filter\MultiReportFilterCollectionInterface;
use Yjv\ReportRendering\IdGenerator\CallCountIdGenerator;
use Yjv\ReportRendering\IdGenerator\IdGeneratorInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Event\FilterDataEvent;
use Yjv\ReportRendering\Event\DataEvent;
use Yjv\ReportRendering\ReportData\ImmutableReportData;
use Yjv\ReportRendering\Renderer\FilterAwareRendererInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yjv\ReportRendering\Filter\NullFilterCollection;
use Yjv\ReportRendering\Renderer\RendererNotFoundException;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

/**
 * 
 * @author yosefderay
 *
 */
class Report implements ReportInterface
{
    protected $datasource;
    protected $renderers = array();
    protected $filters;
    protected $eventDispatcher;
    protected $idGenerator;
    protected $id;

    public function __construct(
        DatasourceInterface $datasource,
        RendererInterface $defaultRenderer,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->datasource = $datasource;
        $this->addRenderer(ReportInterface::DEFAULT_RENDERER_KEY, $defaultRenderer);
        $this->eventDispatcher = $eventDispatcher;
        $this->filters = new NullFilterCollection();
        $this->idGenerator = new CallCountIdGenerator();
    }

    /**
     * 
     * @param string $name
     * @param RendererInterface $renderer
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addRenderer($name, RendererInterface $renderer)
    {
        $this->renderers[$name] = $renderer;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @throws RendererNotFoundException
     * @return RendererInterface
     */
    public function getRenderer($name = ReportInterface::DEFAULT_RENDERER_KEY)
    {
        if (!$this->hasRenderer($name)) {

            throw new RendererNotFoundException($name);
        }

        $renderer = $this->renderers[$name];

        if ($renderer instanceof LazyLoadedRendererInterface) {

            $renderer = $this->renderers[$name] = $renderer->getRenderer();
        }

        $renderer->setReportId($this->getId());

        if ($renderer instanceof FilterAwareRendererInterface) {

            $renderer->setFilters($this->getFilters());
        }

        $renderer->setData($this->getData($name, $renderer));

        return $renderer;
    }
    
    public function hasRenderer($name)
    {
        return isset($this->renderers[$name]);
    }

    /**
     * @return array
     */
    public function getRenderers()
    {
        return $this->renderers;
    }

    /**
     * 
     * @param string $name
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function removeRenderer($name)
    {
        unset($this->renderers[$name]);
        return $this;
    }

    /**
     * 
     * @param string $eventName
     * @param callable $listener
     * @param number $priority
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventListener($eventName, $listener, $priority = 0)
    {
        $this->eventDispatcher->addListener($eventName, $listener, $priority);
        return $this;
    }

    /**
     * 
     * @param EventSubscriberInterface $eventSubscriber
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->addSubscriber($subscriber);
        return $this;
    }

    /**
     * 
     * @return mixed the data returned from the datasoucre filtered by the post load listeners
     */
    public function getData($rendererName, RendererInterface $renderer)
    {
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
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * 
     * @param DatasourceInterface $datasource
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setDatasource(DatasourceInterface $datasource)
    {
        $this->datasource = $datasource;
        return $this;
    }

    /**
     * @return FilterCollectionInterface
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * 
     * @param FilterCollectionInterface $filters
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setFilters(FilterCollectionInterface $filters)
    {
        if ($filters instanceof MultiReportFilterCollectionInterface) {

            $filters->setReportId($this->getId());
        }

        $this->filters = $filters;

        return $this;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * 
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    public function getId()
    {
        $this->generateId();
        return $this->id;
    }

    public function setIdGenerator(IdGeneratorInterface $idGenerator)
    {
        $this->idGenerator = $idGenerator;
        return $this;
    }

    public function __toString()
    {
        return $this->getRenderer()->render();
    }

    /**
     * 
     * @param ImmutableDataInterface $data
     * @return \Yjv\ReportRendering\ReportData\ImmutableReportData
     */
    protected function lockData(ImmutableDataInterface $data)
    {
        return ImmutableReportData::createFromData($data);
    }

    protected function generateId()
    {
        if (empty($this->id)) {

            $this->id = $this->idGenerator->getId($this);
        }

        return $this;
    }
}
