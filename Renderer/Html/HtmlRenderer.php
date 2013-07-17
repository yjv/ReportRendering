<?php
namespace Yjv\ReportRendering\Renderer\Html;

use Yjv\ReportRendering\Renderer\Grid\GridInterface;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Symfony\Component\Form\FormInterface;
use Yjv\ReportRendering\Widget\WidgetRendererInterface;
use Yjv\ReportRendering\Renderer\FilterAwareRendererInterface;
use Yjv\ReportRendering\Widget\WidgetInterface;

class HtmlRenderer implements FilterAwareRendererInterface, WidgetInterface, \IteratorAggregate
{
    protected $filters;
    protected $renderer;
    protected $template;
    protected $attributes = array();
    protected $filterForm;
    protected $grid;
    protected $reportId;
    protected $forceReload = true;

        public function __construct(WidgetRendererInterface $renderer, GridInterface $grid, $template)
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
        return $this;
    }

    public function getForceReload()
    {
        return $this->forceReload;
    }

    public function render(array $options = array())
    {
        return $this->renderer->render($this, $options);
    }

    public function getRows()
    {
        return $this->grid->getRows($this->getForceReload());
    }

    public function getColumns()
    {
        return $this->grid->getColumns();
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
        if (!array_key_exists($name, $this->attributes)) {

            return $default;
        }

        return $this->attributes[$name];
    }

    public function setFilters(FilterCollectionInterface $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function setFilterForm(FormInterface $form)
    {
        $this->filterForm = $form;
        return $this;
    }

    public function getFilterForm()
    {
        $this->assertFilterFormSet();
        $this->assertFiltersSet();
        $this->filterForm->bind($this->filters->all());
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

    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
        return $this;
    }

    public function getReportId()
    {
        return $this->reportId;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getRows());
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
