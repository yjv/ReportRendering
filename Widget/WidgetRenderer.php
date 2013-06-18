<?php
namespace Yjv\ReportRendering\Widget;

use Symfony\Component\Templating\EngineInterface;

class WidgetRenderer implements WidgetRendererInterface
{
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function render(WidgetInterface $widget, array $params = array())
    {
        return $this->templating->render($widget->getTemplate(), array_merge($params, array('widget' => $widget)));
    }
}
