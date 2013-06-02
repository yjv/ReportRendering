<?php
namespace Yjv\ReportRendering\Filter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * filter collection that holds filter values in the session for multiple reports
 * @author yosefderay
 *
 */
class SessionFilterCollection implements 
    MultiReportFilterCollectionInterface,
    DefaultedFilterCollectionInterface
{

    protected $session;
    protected $reportId;
    protected $filters = array();

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
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
        return $this->syncFilters();
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::setAll()
     */
    public function setAll(array $values)
    {
        $this->filters = array_replace($this->filters, $values);
        return $this->syncFilters();
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
        return $this->syncFilters();
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

            $this->filters[$name] = $value;
        }

        return $this->syncFilters();
    }

    /**
     * returns the path to use in the sesison object for storing/retrieving the filters
     * @return string
     */
    protected function getFilterPath()
    {
        return 'report_filter.' . $this->reportId;
    }

    /**
     * loads the filters for the report into the filters array
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    protected function loadFilters()
    {
        $this->filters = $this->session->get($this->getFilterPath(), array());
        return $this;
    }

    /**
     * syncronizes the filters array with the session storage
     * @return \Yjv\ReportRendering\Filter\SessionFilterCollection
     */
    protected function syncFilters()
    {
        $this->session->set($this->getFilterPath(), $this->filters);
        return $this;
    }
}
