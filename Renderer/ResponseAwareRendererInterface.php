<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

interface ResponseAwareRendererInterface extends RendererInterface {

	public function renderResponse(array $options = array());
}
