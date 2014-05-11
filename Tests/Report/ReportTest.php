<?php
namespace Yjv\ReportRendering\Tests\Report;


use Faker\Factory;
use Faker\Generator;
use Mockery;
use Yjv\ReportRendering\Event\DataEvent;
use Yjv\ReportRendering\Event\RendererEvent;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Report\ReportEvents;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\DataInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\ReportData\ImmutableReportData;
use Yjv\ReportRendering\ReportData\ReportData;
use Yjv\ReportRendering\Renderer\RendererNotFoundException;
use Yjv\ReportRendering\Report\Report;
use Yjv\ReportRendering\Tests\EqualsMatcher;

class ReportTest extends \PHPUnit_Framework_TestCase
{
	/** @var  Mockery\MockInterface */
    protected $renderer;
    /** @var  Mockery\MockInterface */
	protected $datasource;
    /** @var  Mockery\MockInterface */
	protected $eventDispatcher;
    /** @var  Mockery\MockInterface */
    protected $filters;
    protected $name;
    /** @var  Report */
    protected $report;

    public function setUp()
    {
		$this->datasource = Mockery::mock('Yjv\\ReportRendering\\Datasource\\DatasourceInterface');
		$this->renderer = Mockery::mock('Yjv\\ReportRendering\\Renderer\\RendererInterface');
		$this->eventDispatcher = Mockery::mock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$this->name = 'report';
        $this->filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface');
        $this->report = new Report($this->name, $this->datasource, $this->renderer, $this->eventDispatcher);
	}
	
	public function testGettersSetters()
    {
		$datasource = $this->getMock('Yjv\\ReportRendering\\Datasource\\DatasourceInterface');
		$eventDispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$this->assertSame($this->datasource, $this->report->getDatasource());
		$this->assertSame($this->report, $this->report->setDatasource($datasource));
		$this->assertSame($datasource,	$this->report->getDatasource());
		$this->assertSame($this->eventDispatcher, $this->report->getEventDispatcher());
        $this->assertSame($this->report, $this->report->setEventDispatcher($eventDispatcher));
		$this->assertSame($eventDispatcher, $this->report->getEventDispatcher());
		$this->assertEquals($this->name, $this->report->getName());
	}

    public function getRendererProvider()
    {
        return array(
            array(true, true),
            array(false, true),
            array(true, false),
            array(false, false)
        );
    }

    /**
     * @dataProvider getRendererProvider
     */
    public function testRendererGettersSetters($listenerReturnsData, $listenerReturnsRenderer)
    {
		$data = $this->setUpGetDataExpectations(ReportInterface::DEFAULT_RENDERER_KEY, $this->renderer, $listenerReturnsData);
        $this->setUpGetRendererExpectations(ReportInterface::DEFAULT_RENDERER_KEY, $this->renderer, $data, $listenerReturnsRenderer);
        $this->assertEquals(array(ReportInterface::DEFAULT_RENDERER_KEY), $this->report->getRendererNames());
        $this->assertSame($this->renderer, $this->report->getRenderer());
        $this->assertSame($this->renderer, $this->report->getRenderer());
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $name = 'name';
        $this->assertSame($this->report, $this->report->addRenderer($name, $renderer));
        $this->assertTrue($this->report->hasRenderer($name));
        $this->assertEquals(array(
            ReportInterface::DEFAULT_RENDERER_KEY,
            $name
        ), $this->report->getRendererNames());
        $data = $this->setUpGetDataExpectations($name, $renderer, $listenerReturnsData);
        $this->setUpGetRendererExpectations($name, $renderer, $data, $listenerReturnsRenderer);
        $this->assertSame($renderer, $this->report->getRenderer($name));
        $this->assertSame($renderer, $this->report->getRenderer($name));
        $this->assertSame($this->report, $this->report->removeRenderer($name));
        $this->assertEquals(array(ReportInterface::DEFAULT_RENDERER_KEY), $this->report->getRendererNames());
        $this->assertFalse($this->report->hasRenderer($name));
    }

    /**
     * @expectedException \Yjv\ReportRendering\Renderer\RendererNotFoundException
     * @expectedExceptionMessage Renderer with the name "xvvcvxc" has not been registered with this report
     */
    public function testExceptionIsThrownWhenRendererNotFound()
    {
        $name = 'xvvcvxc';
        $this->setUpGetRendererExpectations($name, null, null, false, false);
        $this->report->getRenderer($name);
    }

    /**
     * @dataProvider getRendererProvider
     * @expectedException \Yjv\ReportRendering\Renderer\RendererNotFoundException
     * @expectedExceptionMessage Renderer with the name "name" has not been registered with this report
     */
    public function testExceptionIsThrownWhenRendererIsRemoved($listenerReturnsData, $listenerReturnsRenderer)
    {
        $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $name = 'name';
        $this->report->addRenderer($name, $renderer);
        $data = $this->setUpGetDataExpectations($name, $renderer, $listenerReturnsData);
        $this->setUpGetRendererExpectations($name, $renderer, $data, $listenerReturnsRenderer);
        $this->assertSame($renderer, $this->report->getRenderer($name));
        $this->report->removeRenderer($name);
        $this->setUpGetRendererExpectations($name, null, null, false, false);
        $this->report->getRenderer($name);
    }

    /**
     * @dataProvider getRendererProvider
     */
	public function test__toString($listenerReturnsData, $listenerReturnsRenderer)
	{
	    $this->renderer
            ->shouldReceive('render')
            ->once()
            ->andReturn('hello')
            ->getMock()
        ;
        $data = $this->setUpGetDataExpectations(ReportInterface::DEFAULT_RENDERER_KEY, $this->renderer, $listenerReturnsData);
        $this->setUpGetRendererExpectations(ReportInterface::DEFAULT_RENDERER_KEY, $this->renderer, $data, $listenerReturnsRenderer);
        $this->assertEquals('hello', (string)$this->report);
	}

    public function testFiltersGettersSetters() {

		$filters = Mockery::mock('Yjv\\ReportRendering\\Filter\\FilterCollectionInterface');
		$multiReportFilters = Mockery::mock('Yjv\\ReportRendering\\Filter\\MultiReportFilterCollectionInterface');

		$multiReportFilters
			->shouldReceive('setReportName')
            ->once()
            ->with($this->name)
		;

		$this->assertInstanceOf('Yjv\\ReportRendering\\Filter\\FilterCollectionInterface', $this->report->getFilters());
		$this->report->setFilters($filters);
		$this->assertSame($filters, $this->report->getFilters());
		$this->report->setFilters($multiReportFilters);
	}

    public function getDataProvider()
    {
        return array(array(true), array(false));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testGetData($listenerReturnsData)
    {
        $renderer = $this->getMock('Yjv\\ReportRendering\\Renderer\\RendererInterface');
        $rendererName = 'renderer';
        $data = $this->setUpGetDataExpectations($rendererName, $renderer, $listenerReturnsData);
        $this->assertEquals(ImmutableReportData::createFromData($data), $this->report->getData($rendererName, $renderer));
	}
    /**
     * @expectedException \Yjv\ReportRendering\ReportData\DataNotReturnedException
     * @expectedExceptionMessage datasource did not return data
     */
    public function testExceptionIsThrownWhenDataNotReturned()
    {
        $name = 'xvvcvxc';
        $this->setUpGetDataExpectations($name, $this->renderer, false, false);
        $this->report->getData($name, $this->renderer);
    }


    public function testEventListenerAdditions()
    {
		$eventSubscriber = Mockery::mock('Symfony\Component\EventDispatcher\EventSubscriberInterface');
		$eventListener = function(){};
		$event = ReportEvents::POST_LOAD_DATA;

		$this->eventDispatcher
            ->shouldReceive('addListener')
			->once()
			->with($event, $eventListener, 10)
		;

		$this->eventDispatcher
            ->shouldReceive('addSubscriber')
			->once()
			->with($eventSubscriber)
		;

		$this->report->addEventListener($event, $eventListener, 10);
		$this->report->addEventSubscriber($eventSubscriber);
	}

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->report->getName());
    }

    protected function setUpGetDataExpectations($rendererName, RendererInterface $renderer, $listenerReturnsData, $dataReturned = true)
    {
        $this->report->setFilters($this->filters);
        $report = $this->report;
        $datasource = $this->datasource;
        $faker = Factory::create();
        $data = array(
            array($faker->word => $faker->word),
            array($faker->word => $faker->word),
            array($faker->word => $faker->word),
            array($faker->word => $faker->word),
        );
        $filterValues1 = array(
            array($faker->word => $faker->word),
            array($faker->word => $faker->word),
        );
        $filterValues2 = array(
            array($faker->word => $faker->word),
            array($faker->word => $faker->word),
        );
        $this->filters
            ->shouldReceive('all')
            ->once()
            ->andReturn($filterValues1)
        ;
        $data1 = new ReportData($data, count($data));
        $data2 = new ReportData($data, count($data));

        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->once()
            ->with(ReportEvents::PRE_LOAD_DATA, new EqualsMatcher(new DataEvent(
                $report,
                $rendererName,
                $renderer,
                $datasource,
                $filterValues1
            )))
            ->andReturnUsing(function($eventName, DataEvent $event) use (
                $filterValues2,
                $listenerReturnsData,
                $data1
            ) {
                $event->setFilterValues($filterValues2);

                if ($listenerReturnsData) {

                    $event->setData($data1);
                }
                return true;
            })
        ;

        if (!$listenerReturnsData) {

            $this->datasource
                ->shouldReceive('getData')
                ->once()
                ->with($filterValues2)
                ->andReturn($dataReturned ? $data1 : null)
            ;
        }

        if (!$dataReturned) {

            return;
        }

        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->once()
            ->with(ReportEvents::POST_LOAD_DATA, new EqualsMatcher(new DataEvent(
                $report,
                $rendererName,
                $renderer,
                $datasource,
                $filterValues2,
                $data1
            )))
            ->andReturnUsing(function($eventName, DataEvent $event) use (
                $listenerReturnsData,
                $data1,
                $data2
            ) {
                $event->setData($data2);

                if ($listenerReturnsData) {

                    $event->setData($data1);
                }
                return true;
            })
        ;

        return $data2;
    }

    public function setUpGetRendererExpectations($rendererName, RendererInterface $renderer3 = null, DataInterface $data = null, $listenerReturnsRenderer, $rendererReturned = true)
    {
        $renderer1 = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $renderer2 = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $testCase = $this;
        $report = $this->report;
        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->once()
            ->with(ReportEvents::PRE_INITIALIZE_RENDERER, new EqualsMatcher(new RendererEvent(
                $report,
                $rendererName
            )))
            ->andReturnUsing(function($eventName, RendererEvent $event) use (
                $renderer1,
                $listenerReturnsRenderer
            ) {
                if ($listenerReturnsRenderer) {

                    $event->setRenderer($renderer1);
                }
                return true;
            })
        ;

        if (!$listenerReturnsRenderer && $rendererReturned) {

            $this->report->addRenderer($rendererName, $renderer1);
        }

        if (!$rendererReturned) {

            return;
        }

        $renderer2
            ->shouldReceive('setReport')
            ->once()
            ->with($this->report)
            ->getMock()
        ;

        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->once()
            ->with(ReportEvents::INITIALIZE_RENDERER, new EqualsMatcher(new RendererEvent(
                $report,
                $rendererName,
                $renderer1
            )))
            ->andReturnUsing(function($eventName, RendererEvent $event) use (
                $renderer2
            ) {
                $event->setRenderer($renderer2);
                return true;
            })
        ;

        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->once()
            ->with(ReportEvents::POST_INITIALIZE_RENDERER, new EqualsMatcher(new RendererEvent(
                $report,
                $rendererName,
                $renderer2
            )))
            ->andReturnUsing(function($eventName, RendererEvent $event) use (
                $renderer3
            ) {
                $event->setRenderer($renderer3);
                return true;
            })
        ;

        $renderer3
            ->shouldReceive('setData')
            ->once()
            ->with(Mockery::on(function(ImmutableDataInterface $sentData) use ($testCase, $data)
            {
                $testCase->assertEquals(ImmutableReportData::createFromData($data), $sentData);
                return true;
            }))
        ;
    }
}
