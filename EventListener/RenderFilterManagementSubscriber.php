<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/10/14
 * Time: 11:00 PM
 */

namespace Yjv\ReportRendering\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Event\DataEvent;
use Yjv\ReportRendering\Event\RendererEvent;
use Yjv\ReportRendering\Renderer\FilterAwareRendererInterface;
use Yjv\ReportRendering\Renderer\FilterValuesProcessingRendererInterface;
use Yjv\ReportRendering\Report\ReportEvents;

class RenderFilterManagementSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            ReportEvents::POST_INITIALIZE_RENDERER => 'onPostInitializeRenderer',
            ReportEvents::PRE_LOAD_DATA => 'onPreLoadData'
        );
    }

    public function onPostInitializeRenderer(RendererEvent $event)
    {
        $renderer = $event->getRenderer();

        if ($renderer instanceof FilterAwareRendererInterface) {

            $renderer->setFilters($event->getReport()->getFilters());
        }

    }

    public function onPreLoadData(DataEvent $event)
    {
        $renderer = $event->getRenderer();
        $filterValues = $event->getFilterValues();

        if ($renderer instanceof FilterValuesProcessingRendererInterface) {

            $filterValues = $renderer->processFilterValues($filterValues);
        }

        $event->setFilterValues($filterValues);
    }
}