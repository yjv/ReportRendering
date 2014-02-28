<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Builder;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;
use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

class HtmlBuilder extends AbstractRendererBuilder
{
    protected $templatingEngine;
    protected $template;
    protected $widgetAttributes = array();
    protected $filterForm;
    protected $rendererOptions = array();

    public function __construct(
        EngineInterface $templatingEngine,
        TypeFactoryInterface $factory,
        array $options = array()
    ) {
        $this->templatingEngine = $templatingEngine;
        parent::__construct($factory, $options);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplatingEngine()
    {
        return $this->templatingEngine;
    }

    public function setTemplatingEngine(EngineInterface $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
        return $this;
    }

    /**
     * @param FormInterface $filterForm
     * @return $this
     */
    public function setFilterForm(FormInterface $filterForm)
    {
        $this->filterForm = $filterForm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilterForm()
    {
        return $this->filterForm;
    }

    /**
     * @param array $widgetAttributes
     * @return $this
     */
    public function setWidgetAttributes(array $widgetAttributes)
    {
        $this->widgetAttributes = $widgetAttributes;
        return $this;
    }

    /**
     * @return array
     */
    public function getWidgetAttributes()
    {
        return $this->widgetAttributes;
    }

    /**
     * @param array $rendererOptions
     * @return $this
     */
    public function setRendererOptions(array $rendererOptions)
    {
        $this->rendererOptions = $rendererOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getRendererOptions()
    {
        return $this->rendererOptions;
    }

    /**
     * @return HtmlRenderer
     */
    public function getRenderer()
    {
        $renderer =  new HtmlRenderer(
            $this->templatingEngine,
            $this->grid,
            $this->template
        );

        foreach ($this->getWidgetAttributes() as $name => $value) {

            $renderer->setAttribute($name, $value);
        }

        if ($this->getFilterForm()) {

            $renderer->setFilterForm($this->getFilterForm());
        }

        foreach ($this->getRendererOptions() as $name => $value) {

            $renderer->setOption($name, $value);
        }

        return $renderer;
    }
}
