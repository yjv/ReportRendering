<?php
namespace Yjv\ReportRendering\Filter;

/**
 * filter collection that holds filter values in the session for multiple reports
 * @author yosefderay
 *
 */
abstract class AbstractSessionFilterCollection implements 
    MultiReportFilterCollectionInterface,
    DefaultedFilterCollectionInterface
{

    protected $reportId;
    protected $sessionPath = 'report_filters';
    protected $filters = array();

    public function __construct($sessionPath = 'report_filters')
    {
        $this->sessionPath = $sessionPath;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\MultiReportFilterCollectionInterface::setReportId()
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::set()
     */
    public function set($name, $value)
    {
        $this->filters[$name] = $value;
        $this->syncFilters();
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::setAll()
     */
    public function setAll(array $values)
    {
        $this->filters = array_replace($this->filters, $values);
        $this->syncFilters();
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::get()
     */
    public function get($name, $default = null)
    {
        $this->loadFilters();
        return isset($this->filters[$name]) ? $this->filters[$name] : $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::all()
     */
    public function all()
    {
        $this->loadFilters();
        return $this->filters;
    }

    /**
     * 
     * @param array $defaults
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    public function setDefaults(array $defaults)
    {
        $this->filters = array_replace($defaults, $this->filters);
        $this->syncFilters();
        return $this;
    }

    /**
     * 
     * @param unknown $name
     * @param unknown $value
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    public function setDefault($name, $value)
    {
        if (!array_key_exists($name, $this->filters)) {

            $this->set($name, $value);
        }

        return $this;
    }

    /**
     * loads the filters for the report into the filters array
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    abstract protected function loadFilters();

    /**
     * syncronizes the filters array with the session storage
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    abstract protected function syncFilters();
}
