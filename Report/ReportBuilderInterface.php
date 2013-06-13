<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

interface ReportBuilderInterface extends BuilderInterface
{
    /**
     * @return ReportInterface the fully configured report
     */
    public function getReport();

    /**
     * 
     * @param DatasourceInterface $datasource
     */
    public function setDatasource(DatasourceInterface $datasource);

    /**
     * 
     * @param DatasourceInterface $datasource
     */
    public function setFilterCollection(FilterCollectionInterface $filterCollection);

    /**
     * 
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     */
    public function addEventListener($eventName, $listener, $priority);

    /**
     * 
     * @param EventSubscriberInterface $subscriber
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber);

    /**
     * 
     * @param RendererInterface|string|TypeInterface $renderer
     */
    public function setDefaultRenderer($name);

    /**
     * 
     * @param string $name
     * @param RendererInterface|RendererTypeInterface|string $renderer an actual renderer, renderer type
     *  or name of a renderer type
     */
    public function addRenderer($name, $renderer, array $options = array());
}
