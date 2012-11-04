<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

/**
 * @author yosefderay
 *
 */
class RendererRegistry {

	protected $renderers = array();
	
	public function addRenderer($name, RendererInterface $renderer) {
		
		$this->renderers[$name] = $renderer;
		return $this;
	}
	
	public function getRenderer($name) {
		
		if (!isset($this->renderers[$name])) {
			
			throw new RendererNotFoundException($name);
		}
		
		return $this->renderers[$name];
	}
}
