<?php
namespace Yjv\ReportRendering\Renderer\Html;

use Symfony\Component\Templating\EngineInterface;

use Yjv\ReportRendering\FilterConstants;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\Renderer\Html\Filter\FormInterface;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Renderer\FilterAwareRendererInterface;

class HtmlRenderer implements FilterAwareRendererInterface
{
    const DEFAULT_PAGINATION_OVERFLOW = 3;
    const PAGINATION_OVERFLOW_KEY = 'pagination_overflow';
    
    /** @var  FilterCollectionInterface */
    protected $filters;
    /** @var EngineInterface  */
    protected $renderer;
    /** @var  string */
    protected $template;
    protected $attributes = array();
    protected $options = array();
    /** @var  FormInterface|null */
    protected $filterForm;
    /** @var  ImmutableDataInterface */
    protected $data;
    /** @var GridInterface  */
    protected $grid;
    /** @var  ReportInterface */
    protected $report;
    protected $forceReload = false;
    protected $javascripts = array();
    protected $stylesheets = array();

    public function __construct(EngineInterface $renderer, GridInterface $grid, $template)
    {
        $this->renderer = $renderer;
        $this->template = $template;
        $this->grid = $grid;
    }

    public function setData(ImmutableDataInterface $data)
    {
        $this->data = $data;
        $this->grid->setData($data);
        return $this;
    }

    public function setForceReload($forceReload)
    {
        $this->forceReload = $forceReload;
        $this->grid->setForceReload($forceReload);
        return $this;
    }

    public function getForceReload()
    {
        return $this->forceReload;
    }

    public function render(array $options = array())
    {
        return $this->renderer->render($this->template, array_merge($options, array('renderer' => $this)));
    }
    
    public function getGrid()
    {
        return $this->grid;
    }

    public function getUnpaginatedCount()
    {
        $this->assertDataSet();
        return $this->data->getUnpaginatedCount();
    }

    public function getCount()
    {
        $this->assertDataSet();
        return $this->data->getCount();
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($name, $default = null)
    {
        if (!isset($this->attributes[$name]) && !array_key_exists($name, $this->attributes)) {

            return $default;
        }

        return $this->attributes[$name];
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($name, $default = null)
    {
        if (!isset($this->options[$name]) && !array_key_exists($name, $this->options)) {

            return $default;
        }

        return $this->options[$name];
    }

    public function setFilters(FilterCollectionInterface $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * @return FilterCollectionInterface
     */
    public function getFilters()
    {
        return $this->filters;
    }

    public function setFilterForm(FormInterface $form)
    {
        $this->filterForm = $form;
        return $this;
    }

    /**
     * @return FormInterface
     */
    public function getFilterForm()
    {
        $this->assertFilterFormSet();
        $this->assertFiltersSet();

        static $filtersSet = false;

        if (!$filtersSet) {

            $this->filterForm->setFilters($this->filters->all());
            $filtersSet = true;
        }

        return $this->filterForm;
    }

    public function hasFilterForm()
    {
        return !empty($this->filterForm);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setReport(ReportInterface $report)
    {
        $this->report = $report;
        return $this;
    }

    public function getReport()
    {
        return $this->report;
    }
    
    public function getPage()
    {
        $offset = $this->filters->get(FilterConstants::OFFSET, FilterConstants::DEFAULT_OFFSET);
        $limit = $this->filters->get(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT);
        return (int)floor($offset / $limit + 1);
    }
    
    public function getPageCount()
    {
        $limit = $this->filters->get(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT);
        $unpaginatedCount = $this->getUnpaginatedCount();
        return (int)ceil($unpaginatedCount / $limit);
    }
    
    public function getMinPage()
    {
        $paginationOverflow = $this->getOption(self::PAGINATION_OVERFLOW_KEY, self::DEFAULT_PAGINATION_OVERFLOW);
        return (int)max(1, $this->getPage() - $paginationOverflow);
    }
    
    public function getMaxPage()
    {
        $paginationOverflow = $this->getOption(self::PAGINATION_OVERFLOW_KEY, self::DEFAULT_PAGINATION_OVERFLOW);
        return (int)min($this->getPageCount(), $this->getPage() + $paginationOverflow);
    }

    public function getJavascripts()
    {
        return $this->javascripts;
    }

    public function addJavascript($name, $path)
    {
        $this->javascripts[$name] = $path;
        return $this;
    }

    public function removeJavascript($name)
    {
        unset($this->javascripts[$name]);
        return $this;
    }

    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    public function addStylesheet($name, $path)
    {
        $this->stylesheets[$name] = $path;
        return $this;
    }

    public function removeStylesheet($name)
    {
        unset($this->stylesheets[$name]);
        return $this;
    }

    protected function assertDataSet()
    {
        if (empty($this->data)) {

            throw new \BadMethodCallException('data must be set to use this method');
        }
    }

    protected function assertFilterFormSet()
    {
        if (empty($this->filterForm)) {

            throw new \BadMethodCallException('filterForm must be set to use this method');
        }
    }

    protected function assertFiltersSet()
    {
        if (empty($this->filters)) {

            throw new \BadMethodCallException('filters must be set to use this method');
        }
    }
}
