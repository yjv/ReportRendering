<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/11/14
 * Time: 4:54 PM
 */

namespace Yjv\ReportRendering\Tests\EventListener;


use Yjv\ReportRendering\EventListener\LazyLoadedRendererManagementSubscriber;
use Yjv\ReportRendering\Report\ReportEvents;

class LazyLoadedRendererManagementSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /** @var  LazyLoadedRendererManagementSubscriber */
    protected $subscriber;

    public function setUp()
    {
        $this->subscriber = new LazyLoadedRendererManagementSubscriber();
    }

    public function testGetSubscribedEvents()
    {
        $this->assertEquals(array(
            ReportEvents::INITIALIZE_RENDERER => array('onInitializeRenderer', 100)
        ), $this->subscriber->getSubscribedEvents());
    }

    public function testOnInitializeRendererWhereRendererNotLazyLoaded()
    {
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $event = \Mockery::mock('Yjv\ReportRendering\Event\RendererEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
        ;
        $this->subscriber->onInitializeRenderer($event);
    }

    public function testOnInitializeRendererWhereRendererLazyLoaded()
    {
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $lazyLoadedRenderer = \Mockery::mock('Yjv\ReportRendering\Renderer\LazyLoadedRendererInterface')
            ->shouldReceive('getRenderer')
            ->andReturn($renderer)
            ->getMock()
        ;
        $event = \Mockery::mock('Yjv\ReportRendering\Event\RendererEvent')
            ->shouldReceive('getRenderer')
            ->andReturn($lazyLoadedRenderer)
            ->getMock()
            ->shouldReceive('setRenderer')
            ->with($renderer)
            ->getMock()
        ;
        $this->subscriber->onInitializeRenderer($event);
    }
}
 