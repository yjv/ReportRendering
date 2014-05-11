<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/10/14
 * Time: 10:34 PM
 */

namespace Yjv\ReportRendering\Event;


use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Report\ReportInterface;

class RendererEvent extends ReportEvent
{
    protected $rendererName;
    protected $renderer;

    public function __construct(ReportInterface $report, $rendererName, RendererInterface $renderer = null)
    {
        parent::__construct($report);
        $this->rendererName = $rendererName;
        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function getRendererName()
    {
        return $this->rendererName;
    }

    /**
     * @param RendererInterface $renderer
     * @return $this
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    /**
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}