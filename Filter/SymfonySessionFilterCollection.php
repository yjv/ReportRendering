<?php
namespace Yjv\ReportRendering\Filter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * filter collection that holds filter values in the session for multiple reports
 * @author yosefderay
 *
 */
class SymfonySessionFilterCollection extends AbstractSessionFilterCollection
{
    protected $session;

    public function __construct(SessionInterface $session, $sessionPath = 'report_filters')
    {
        $this->session = $session;
        parent::__construct($sessionPath);
    }

    /**
     * returns the path to use in the session object for storing/retrieving the filters
     * @return string
     */
    protected function getFilterPath()
    {
        return $this->sessionPath . '.' . $this->reportName;
    }

    /**
     * loads the filters for the report into the filters array
     * @return $this
     */
    protected function loadFilters()
    {
        $this->filters = $this->session->get($this->getFilterPath(), array());
        return $this;
    }

    /**
     * syncronizes the filters array with the session storage
     * @return $this
     */
    protected function syncFilters()
    {
        $this->session->set($this->getFilterPath(), $this->filters);
        return $this;
    }
}
