<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

/**
 * @author yosefderay
 *
 */
interface RendererInterface
{
    /**
     * sets the data to be rendered
     * @param ImmutableDataInterface $data
     */
    public function setData(ImmutableDataInterface $data);

    /**
     * if the data should be reloaded even if it has already loaded  before
     */
    public function getForceReload();

    /**
     * should return the fully rendered content for return to the client
     * @param array $options
     */
    public function render(array $options = array());

    /**
     * sets the report's id
     * @param \Yjv\ReportRendering\Report\ReportInterface $report
     * @return
     */
    public function setReport(ReportInterface $report);
}