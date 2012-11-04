<?php
namespace Yjv\Bundle\ReportRenderingBundle\Widget;

interface CompoundWidgetInterface extends WidgetInterface{

	const INSERT_BEFORE = 'before';
	const INSERT_AFTER = 'after';
	
	public function add($name, WidgetInterface $widget, $insertMode = self::INSERT_AFTER, $referenceWidget = null);
	public function remove($name);
	public function get($name);
}
