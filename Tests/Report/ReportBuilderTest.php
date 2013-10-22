<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Report\ReportBuilder;

use Mockery;

class ReportBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $options;
    protected $eventDispatcher;
    protected $factory;
    protected $rendererFactory;
    protected $datasourceFactory;
    
    public function setUp()
    {
        $this->eventDispatcher = Mockery::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
        $this->datasourceFactory = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceFactoryInterface');
        $this->factory = Mockery::mock('Yjv\ReportRendering\Report\ReportFactoryInterface')
            ->shouldReceive('getRendererFactory')
            ->andReturn($this->rendererFactory)
            ->getMock()
            ->shouldReceive('getDatasourceFactory')
            ->andReturn($this->datasourceFactory)
            ->getMock()
        ;
        $this->options = array('key' => 'value');
        $this->builder = new ReportBuilder($this->factory, $this->eventDispatcher, $this->options);
    }
    
    public function testOptionsArePassed()
    {
        $this->assertEquals($this->options, $this->builder->getOptions());
    }
    
    public function testGetReport()
    {
        $datasource = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface');
        $datasource2 = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface');
        $datasourceName = 'datasource';
        $datasourceOptions = array('key' => 'value');
        $defaultRenderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $filterCollection = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface');
        $idGenerator = Mockery::mock('Yjv\ReportRendering\IdGenerator\IdGeneratorInterface')
            ->shouldReceive('getId')
            ->andReturn('hello')
            ->getMock()        
        ;
        $this->datasourceFactory
            ->shouldReceive('create')
            ->once()
            ->with($datasourceName, $datasourceOptions)
            ->andReturn($datasource2)
        ;
        $this->assertSame($this->builder, $this->builder
            ->setDatasource($datasource)
            ->setDefaultRenderer('name')
            ->addRenderer('name', $renderer)
            ->addRenderer('name2', 'renderer', array('key' => 'value'))
            ->setIdGenerator($idGenerator)
        );
        $report = $this->builder->getReport();
        $this->builder->setDatasource($datasourceName, $datasourceOptions);
        $report2 = $this->builder->getReport();
        $this->assertTrue($report->hasRenderer('name'));
        $this->assertTrue($report->hasRenderer('name2'));
        $this->assertTrue($report->hasRenderer('default'));
        $this->assertSame($datasource, $report->getDatasource());
        $this->assertSame($datasource2, $report2->getDatasource());
        $this->assertSame($this->eventDispatcher, $report->getEventDispatcher());
        $this->assertInstanceOf('Yjv\ReportRendering\Filter\NullFilterCollection', $report->getFilters());
        $this->assertEquals('hello', $report->getId());
        $this->builder->setFilters($filterCollection);
        $report = $this->builder->getReport();
        $this->assertSame($filterCollection, $report->getFilters());
    }
    
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The datasource is required to build the report
     */
    public function testGetReportWithDatasourceNotSet()
    {
        $this->builder->getReport();
    }
    
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The default renderer is required to build the report
     */
    public function testGetReportWithDefaultRendererNotSet()
    {
        $this->builder->setDatasource(Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface'));
        $this->builder->getReport();
    }
    
    public function testAddEventListener()
    {
        $eventName = 'name';
        $listener = function(){};
        $priority = 10;
        
        $this->eventDispatcher
            ->shouldReceive('addListener')
            ->once()
            ->with($eventName, $listener, $priority)
        ;
        $this->builder->addEventListener($eventName, $listener, $priority);
    }
    
    public function testAddEventSubscriber()
    {
        $subscriber = Mockery::mock('Symfony\Component\EventDispatcher\EventSubscriberInterface');
        $this->eventDispatcher
            ->shouldReceive('addSubscriber')
            ->once()
            ->with($subscriber)
        ;
        $this->builder->addEventSubscriber($subscriber);
    }
}
