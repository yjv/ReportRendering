<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\IdGenerator\IdGeneratorInterface;

use Yjv\ReportRendering\Renderer\LazyLoadedRenderer;

use Yjv\ReportRendering\Factory\Builder;

use Yjv\ReportRendering\Factory\TypeInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

class ReportBuilder extends Builder implements ReportBuilderInterface
{
    protected $renderers = array();
    protected $defaultRenderer = 'default';
    protected $datasource;
    protected $filterCollection;
    protected $eventDispatcher;
    protected $idGenerator;

    public function __construct(ReportFactoryInterface $factory, EventDispatcherInterface $eventDispatcher, array $options = array())
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($factory, $options);
    }

    /**
     * @return ReportInterface the fully configured report
     */
    public function getReport()
    {
        $this->assertBuildable();
        
        $report = new Report($this->datasource, $this->renderers[$this->defaultRenderer], $this->eventDispatcher);

        if ($this->filterCollection) {

            $report->setFilters($this->filterCollection);
        }

        foreach ($this->renderers as $name => $renderer) {

            $report->addRenderer($name, $renderer);
        }
        
        if ($this->idGenerator) {
            
            $report->setIdGenerator($this->idGenerator);
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
    public function setFilters(FilterCollectionInterface $filterCollection)
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
        $renderer = $this->normalizeRenderer($renderer, $options);
        
        if (!$renderer instanceof RendererInterface) {
            
            throw new \InvalidArgumentException(
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
    public function setDefaultRenderer($name)
    {
        $this->defaultRenderer = (string)$name;
        return $this;
    }
    
    public function setIdGenerator(IdGeneratorInterface $idGenerator)
    {
        $this->idGenerator = $idGenerator;
        return $this;
    }
    
    protected function normalizeRenderer($renderer, array $options = array())
    {
        if (is_string($renderer) || $renderer instanceof TypeInterface) {
            
            $renderer = new LazyLoadedRenderer(
                $this->factory->getRendererFactory(), 
                $renderer, 
                $options
            );
        }
        
        return $renderer;
    }
    
    protected function assertBuildable()
    {
        if (!$this->datasource) {
            
            throw new \RuntimeException('The datasource is required to build the report');
        }
        
        if (!$this->defaultRenderer || !isset($this->renderers[$this->defaultRenderer])) {
            
            throw new \RuntimeException('The default renderer is required to build the report');
        }
    }
}
