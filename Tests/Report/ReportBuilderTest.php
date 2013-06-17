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
    
    public function setUp()
    {
        $this->eventDispatcher = Mockery::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
        $this->factory = Mockery::mock('Yjv\ReportRendering\Report\ReportFactoryInterface')
            ->shouldReceive('getRendererFactory')
            ->andReturn($this->rendererFactory)
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
        $defaultRenderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $filterCollection = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface');
        $idGenerator = Mockery::mock('Yjv\ReportRendering\IdGenerator\IdGeneratorInterface')
            ->shouldReceive('getId')
            ->andReturn('hello')
            ->getMock()        
        ;
        $this->assertSame($this->builder, $this->builder
            ->setDatasource($datasource)
            ->setDefaultRenderer('name')
            ->addRenderer('name', $renderer)
            ->addRenderer('name2', 'renderer', array('key' => 'value'))
            ->setIdGenerator($idGenerator)
        );
        $report = $this->builder->getReport();
        $this->assertTrue($report->hasRenderer('name'));
        $this->assertTrue($report->hasRenderer('name2'));
        $this->assertTrue($report->hasRenderer('default'));
        $this->assertSame($datasource, $report->getDatasource());
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
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage $renderer must either an renderer type, type name or instance of RendererInterface
     */
    public function testAddRendererWithInvalidRenderer()
    {
        $this->builder->addRenderer('name', new \stdClass());
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
