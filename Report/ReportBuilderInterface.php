<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererTypeDelegateInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;
use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

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
     * @param RendererInterface $renderer
     */
    public function setDefaultRenderer(RendererInterface $renderer);

    /**
     * 
     * @param string $name
     * @param RendererInterface|RendererTypeInterface|string $renderer an actual renderer, renderer type
     *  or name of a renderer type
     */
    public function addRenderer($name, $renderer, array $options = array());
}
