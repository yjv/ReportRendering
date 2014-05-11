<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\IdGenerator\IdGeneratorInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

/**
 * 
 * @author yosefderay
 *
 */
interface ReportInterface
{
    const DEFAULT_RENDERER_KEY = 'default';
    
    /**
     * 
     * @param string $name
     * @param RendererInterface $renderer
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addRenderer($name, RendererInterface $renderer);

    /**
     * 
     * @param string $name
     * @throws RendererNotFoundException
     * @return RendererInterface
     */
    public function getRenderer($name = 'default');
    
    /**
     * 
     * @param string $name
     * @return boll
     */
    public function hasRenderer($name);

    /**
     * @return array
     */
    public function getRendererNames();

    /**
     * 
     * @param string $name
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function removeRenderer($name);

    /**
     * 
     * @param string $eventName
     * @param callable $listener
     * @param number $priority
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventListener($eventName, $listener, $priority = 0);

    /**
     * 
     * @param EventSubscriberInterface $eventSubscriber
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber);

    /**
     * 
     * @return mixed the data returned from the datasoucre filtered by the post load listeners
     */
    public function getData($rendererName, RendererInterface $renderer);

    /**
     * @return DatasourceInterface
     */
    public function getDatasource();

    /**
     * 
     * @param DatasourceInterface $datasource
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setDatasource(DatasourceInterface $datasource);

    /**
     * @return FilterCollectionInterface
     */
    public function getFilters();

    /**
     * 
     * @param FilterCollectionInterface $filters
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setFilters(FilterCollectionInterface $filters);

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * 
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Yjv\ReportRendering\Report\Report
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);

    public function getName();
}
