<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

/**
 * @author yosefderay
 *
 */
class RendererRegistry {

	protected $renderers = array();
	
	/**
	 * 
	 * @param string $name
	 * @param RendererInterface $renderer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\RendererRegistry
	 */
	public function set($name, RendererInterface $renderer) {
		
		$this->renderers[$name] = $renderer;
		return $this;
	}
	
	/**
	 * 
	 * @param string $name
	 * @throws RendererNotFoundException
	 * @return RendererInterface a renderer
	 */
	public function get($name) {
		
		if (!isset($this->renderers[$name])) {
			
			throw new RendererNotFoundException($name);
		}
		
		return $this->renderers[$name];
	}
}
