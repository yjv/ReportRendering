<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/10/14
 * Time: 11:06 PM
 */

namespace Yjv\ReportRendering\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Event\RendererEvent;
use Yjv\ReportRendering\Renderer\LazyLoadedRendererInterface;
use Yjv\ReportRendering\Report\ReportEvents;

class LazyLoadedRendererManagementSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            ReportEvents::INITIALIZE_RENDERER => array('onInitializeRenderer', 100)
        );
    }

    public function onInitializeRenderer(RendererEvent $event)
    {
        $renderer = $event->getRenderer();

        if ($renderer instanceof LazyLoadedRendererInterface) {

            $event->setRenderer($renderer->getRenderer());
        }
    }
}