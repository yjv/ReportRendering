<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Builder;

use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;
use Yjv\ReportRendering\Renderer\Html\Filter\FormInterface;
use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

class HtmlBuilder extends AbstractRendererBuilder
{
    protected $templatingEngine;
    protected $template;
    protected $widgetAttributes = array();
    protected $filterForm;
    protected $rendererOptions = array();
    protected $javascripts = array();

    protected $stylesheets = array();
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
     * @param array $javascripts
     * @return $this
     */
    public function setJavascripts(array $javascripts)
    {
        $this->javascripts = $javascripts;
        return $this;
    }

    /**
     * @return array
     */
    public function getJavascripts()
    {
        return $this->javascripts;
    }

    /**
     * @param array $stylesheets
     * @return $this
     */
    public function setStylesheets(array $stylesheets)
    {
        $this->stylesheets = $stylesheets;
        return $this;
    }

    /**
     * @return array
     */
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    /**
     * @throws \RuntimeException
     * @return HtmlRenderer
     */
    public function getRenderer()
    {
        if (!$this->getTemplatingEngine()) {

            throw new \RuntimeException('The templating engine is required to build the html renderer');
        }

        $renderer =  new HtmlRenderer(
            $this->getTemplatingEngine(),
            $this->getGrid(),
            $this->getTemplate()
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

        foreach ($this->getJavascripts() as $name => $path) {

            $renderer->addJavascript($name, $path);
        }

        foreach ($this->getStylesheets() as $name => $path) {

            $renderer->addStylesheet($name, $path);
        }

        return $renderer;
    }
}
