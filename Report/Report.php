<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Event\RendererEvent;
use Yjv\ReportRendering\Filter\MultiReportFilterCollectionInterface;
use Yjv\ReportRendering\ReportData\DataInterface;
use Yjv\ReportRendering\ReportData\DataNotReturnedException;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Event\DataEvent;
use Yjv\ReportRendering\ReportData\ImmutableReportData;
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
    /** @var RendererInterface[] */
    protected $renderers = array();
    protected $initializedRenderers = array();
    protected $filters;
    protected $eventDispatcher;
    protected $name;

    public function __construct(
        $name,
        DatasourceInterface $datasource,
        RendererInterface $defaultRenderer,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->datasource = $datasource;
        $this->addRenderer(ReportInterface::DEFAULT_RENDERER_KEY, $defaultRenderer);
        $this->eventDispatcher = $eventDispatcher;
        $this->filters = new NullFilterCollection();
        $this->name = $name;
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
        if (isset($this->initializedRenderers[$name])) {

            return $this->initializedRenderers[$name];
        }

        $event = new RendererEvent($this, $name);
        $this->eventDispatcher->dispatch(
            ReportEvents::PRE_INITIALIZE_RENDERER,
            $event
        );
        $renderer = $event->getRenderer();

        if (!$renderer) {

            if (!$this->hasRenderer($name)) {

                throw new RendererNotFoundException($name);
            }

            $renderer = $this->renderers[$name];
        }

        $event = new RendererEvent($this, $name, $renderer);
        $this->eventDispatcher->dispatch(
            ReportEvents::INITIALIZE_RENDERER,
            $event
        );
        $renderer = $event->getRenderer();

        $renderer->setReport($this);

        $event = new RendererEvent($this, $name, $renderer);
        $this->eventDispatcher->dispatch(
            ReportEvents::POST_INITIALIZE_RENDERER,
            $event
        );
        $renderer = $event->getRenderer();

        $renderer->setData($this->getData($name, $renderer));

        return $this->initializedRenderers[$name] = $renderer;
    }
    
    public function hasRenderer($name)
    {
        return isset($this->renderers[$name]);
    }

    /**
     * @return RendererInterface[]
     */
    public function getRendererNames()
    {
        return array_keys($this->renderers);
    }

    /**
     * 
     * @param string $name
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function removeRenderer($name)
    {
        unset($this->renderers[$name], $this->initializedRenderers[$name]);
        return $this;
    }

    /**
     *
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventListener($eventName, $listener, $priority = 0)
    {
        $this->eventDispatcher->addListener($eventName, $listener, $priority);
        return $this;
    }

    /**
     *
     * @param \Symfony\Component\EventDispatcher\EventSubscriberInterface $subscriber
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->addSubscriber($subscriber);
        return $this;
    }

    /**
     *
     * @param $rendererName
     * @param \Yjv\ReportRendering\Renderer\RendererInterface $renderer
     * @throws \Yjv\ReportRendering\ReportData\DataNotReturnedException
     * @return mixed the data returned from the datasource filtered by the post load listeners
     */
    public function getData($rendererName, RendererInterface $renderer)
    {
        $filterValues = $this->filters->all();

        $dataEvent = new DataEvent(
            $this,
            $rendererName,
            $renderer,
            $this->datasource,
            $filterValues
        );
        $this->eventDispatcher->dispatch(ReportEvents::PRE_LOAD_DATA, $dataEvent);
        $data = $dataEvent->getData();
        $filterValues = $dataEvent->getFilterValues();

        if (!$data instanceof DataInterface) {

            $data = $this->datasource->getData($filterValues);

            if (!$data instanceof ImmutableDataInterface) {

                throw new DataNotReturnedException();
            }
        }

        $dataEvent = new DataEvent(
            $this,
            $rendererName,
            $renderer,
            $this->datasource,
            $filterValues,
            $data
        );
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

            $filters->setReportName($this->getName());
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

    public function getName()
    {
        return $this->name;
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
}
