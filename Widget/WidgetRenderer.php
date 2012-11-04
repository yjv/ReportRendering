<?php
namespace Yjv\Bundle\ReportRenderingBundle\Widget;

use Symfony\Component\Templating\EngineInterface;

class WidgetRenderer {

	protected $templating;
	
	public function __construct(EngineInterface $templating){
		
		$this->templating = $templating;
	}
	
	public function render(WidgetInterface $widget, array $params = array()) {
		
		return $this->templating->render($widget->getTemplate(), array_merge(array('widget' => $widget), $params));
	}
}
