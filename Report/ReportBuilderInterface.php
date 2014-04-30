<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\IdGenerator\IdGeneratorInterface;

use Yjv\TypeFactory\BuilderInterface;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;
use Yjv\TypeFactory\TypeInterface;

interface ReportBuilderInterface extends BuilderInterface
{
    /**
     *
     * @param DatasourceInterface $datasource
     * @param array $options
     * @return $this
     */
    public function setDatasource($datasource, array $options = array());

    /**
     *
     * @param \Yjv\ReportRendering\Filter\FilterCollectionInterface $filterCollection
     * @return $this
     */
    public function setFilters(FilterCollectionInterface $filterCollection);

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
     * @param string $name
     * @return $this
     */
    public function setDefaultRenderer($name);

    /**
     *
     * @param string $name
     * @param RendererInterface|TypeInterface|string $renderer an actual renderer, renderer type
     *  or name of a renderer type
     * @param array $options
     * @return
     */
    public function addRenderer($name, $renderer, array $options = array());
}
