<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/11/14
 * Time: 5:02 PM
 */

namespace Yjv\ReportRendering\Tests\EventListener;


use Faker\Factory;
use Yjv\ReportRendering\EventListener\RendererFilterManagementSubscriber;
use Yjv\ReportRendering\Report\ReportEvents;

class RendererFilterManagementSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /** @var  RendererFilterManagementSubscriber */
    protected $subscriber;

    public function setUp()
    {
        $this->subscriber = new RendererFilterManagementSubscriber();
    }

    public function testGetSubscribedEvents()
    {
        $this->assertEquals(array(
            ReportEvents::POST_INITIALIZE_RENDERER => 'onPostInitializeRenderer',
            ReportEvents::PRE_LOAD_DATA => 'onPreLoadData'
        ), $this->subscriber->getSubscribedEvents());
    }

    public function testOnPostInitializeRendererWhereRendererNotFilterAware()
    {
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $event = \Mockery::mock('Yjv\ReportRendering\Event\RendererEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
        ;
        $this->subscriber->onPostInitializeRenderer($event);
    }

    public function testOnPostInitializeRendererWhereRendererFilterAware()
    {
        $filters = \Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface');
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\FilterAwareRendererInterface')
            ->shouldReceive('setFilters')
            ->once()
            ->with($filters)
            ->getMock()
        ;
        $event = \Mockery::mock('Yjv\ReportRendering\Event\RendererEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
        ;
        $event
            ->shouldReceive('getReport->getFilters')
            ->andReturn($filters)
        ;
        $this->subscriber->onPostInitializeRenderer($event);
    }

    public function testOnPreLoadDataWhereRendererDoesntProcessFilters()
    {
        $faker = Factory::create();
        $filterValues = array(
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
        );
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $event = \Mockery::mock('Yjv\ReportRendering\Event\DataEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
            ->shouldReceive('getFilterValues')
            ->andReturn($filterValues)
            ->getMock()
            ->shouldReceive('setFilterValues')
            ->with($filterValues)
            ->getMock()
        ;
        $this->subscriber->onPreLoadData($event);
    }

    public function testOnPreLoadDataWhereRendererProcessesFilters()
    {
        $faker = Factory::create();
        $filterValues = array(
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
        );
        $processedFilterValues = array(
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
            $faker->word => $faker->word,
        );
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\FilterValuesProcessingRendererInterface')
            ->shouldReceive('processFilterValues')
            ->with($filterValues)
            ->andReturn($processedFilterValues)
            ->getMock()
        ;
        $event = \Mockery::mock('Yjv\ReportRendering\Event\DataEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
            ->shouldReceive('getFilterValues')
            ->andReturn($filterValues)
            ->getMock()
            ->shouldReceive('setFilterValues')
            ->with($processedFilterValues)
            ->getMock()
        ;
        $this->subscriber->onPreLoadData($event);
    }
}
 