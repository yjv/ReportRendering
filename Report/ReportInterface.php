<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Filter\MultiReportFilterCollectionInterface;
use Yjv\Bundle\ReportRenderingBundle\IdGenerator\IdGeneratorInterface;
use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;
use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;
use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

/**
 * 
 * @author yosefderay
 *
 */
interface ReportInterface
{
    /**
     * 
     * @param string $name
     * @param RendererInterface $renderer
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
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
    public function getRenderers();

    /**
     * 
     * @param string $name
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
     */
    public function removeRenderer($name);

    /**
     * 
     * @param string $eventName
     * @param callable $listener
     * @param number $priority
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
     */
    public function addEventListener($eventName, $listener, $priority = 0);

    /**
     * 
     * @param EventSubscriberInterface $eventSubscriber
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
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
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
     */
    public function setDatasource(DatasourceInterface $datasource);

    /**
     * @return FilterCollectionInterface
     */
    public function getFilters();

    /**
     * 
     * @param FilterCollectionInterface $filters
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
     */
    public function setFilters(FilterCollectionInterface $filters);

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * 
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Yjv\Bundle\ReportRenderingBundle\Report\Report
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);

    public function getId();

    public function setIdGenerator(IdGeneratorInterface $idGenerator);
}
