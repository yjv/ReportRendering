<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

/**
 * @author yosefderay
 *
 */
interface RendererInterface {

	public function setData(ImmutableDataInterface $data);
	public function getForceReload();
	public function render(array $options = array());
	public function setReportId($reportId);
}
