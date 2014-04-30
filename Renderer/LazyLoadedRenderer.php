<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

class LazyLoadedRenderer implements LazyLoadedRendererInterface
{
    protected $rendererFactory;
    protected $type;
    protected $options;
    /** @var  RendererInterface */
    protected $renderer;

    public function __construct(RendererFactoryInterface $rendererFactory, $type, array $options)
    {
        $this->rendererFactory = $rendererFactory;
        $this->type = $type;
        $this->options = $options;
    }

    public function getRenderer()
    {
        $this->load();
        return $this->renderer;
    }

    /**
     * 
     */
    public function getForceReload()
    {
        $this->load();
        return $this->renderer->getForceReload();
    }

    /**
     * @param array $options
     */
    public function render(array $options = array())
    {
        $this->load();
        return $this->renderer->render($options);
    }

    /**
     * @param ImmutableDataInterface $data
     * @return $this
     */
    public function setData(ImmutableDataInterface $data)
    {
        $this->load();
        $this->renderer->setData($data);
        return $this;
    }

    /**
     * @param \Yjv\ReportRendering\Report\ReportInterface $report
     * @return $this
     */
    public function setReport(ReportInterface $report)
    {
        $this->load();
        $this->renderer->setReport($report);
        return $this;
    }

    protected function load()
    {
        if ($this->renderer) {

            return;
        }

        $this->renderer = $this->rendererFactory->create($this->type, $this->options);
    }
}
