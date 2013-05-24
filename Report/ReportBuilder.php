<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Factory\Builder;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererTypeDelegateInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;
use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

class ReportBuilder extends Builder implements ReportBuilderInterface
{
    protected $renderers = array();
    protected $defaultRenderer;
    protected $datasource;
    protected $filterCollection;
    protected $eventDispatcher;
    protected $reportFactory;

    public function __construct(ReportFactoryInterface $reportFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->reportFactory = $reportFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return ReportInterface the fully configured report
     */
    public function getReport()
    {
        $this->assertBuildable();
        
        $report = new Report($this->datasource, $this->defaultRenderer, $this->eventDispatcher);

        if ($this->filterCollection) {

            $report->setFilters($this->filterCollection);
        }

        foreach ($this->renderers as $name => $renderer) {

            $report->addRenderer($name, $renderer);
        }

        return $report;
    }

    /**
     * 
     * @param DatasourceInterface $datasource
     */
    public function setDatasource(DatasourceInterface $datasource)
    {
        $this->datasource = $datasource;
        return $this;
    }

    /**
     * 
     * @param DatasourceInterface $datasource
     */
    public function setFilterCollection(FilterCollectionInterface $filterCollection)
    {
        $this->filterCollection = $filterCollection;
        return $this;
    }

    /**
     *
     * {@inherited}
     */
    public function addRenderer($name, $renderer, array $options = array())
    {
        if (is_string($renderer) || $renderer instanceof TypeInterface) {
            
            $renderer = $this
                ->reportFactory
                ->getRendererFactory()
                ->create($renderer, $options)
            ;
        }
        
        if (!$renderer instanceof RendererInterface) {
            
            throw new \BadMethodCallException(
                '$renderer must either an renderer type, type name or instance of RendererInterface'
            );
        }
        
        $this->renderers[$name] = $renderer;
        return $this;
    }

    /**
     *
     * {@inherited}
     */
    public function getReportFactory()
    {
        return $this->reportFactory;
    }

    /**
     * 
     * {@inherited}
     */
    public function addEventListener($eventName, $listener, $priority = 0)
    {
        $this->eventDispatcher->addListener($eventName, $listener, $priority);
        return $this;
    }

    /**
     * 
     * {@inherited}
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->addSubscriber($subscriber);
        return $this;
    }

    /**
     * 
     * {@inherited}
     */
    public function setDefaultRenderer(RendererInterface $renderer)
    {
        $this->defaultRenderer = $renderer;
        return $this;
    }
    
    protected function assertBuildable()
    {
        if (!$this->datasource) {
            
            throw new \RuntimeException('The datasource is required to build the report');
        }
        
        if (!$this->defaultRenderer) {
            
            throw new \RuntimeException('The default renderer is required to build the report');
        }
    }
}
