<?php
namespace Yjv\ReportRendering\Filter;

class NativeSessionFilterCollection extends AbstractSessionFilterCollection
{
    protected function syncFilters() 
    {
        global $_SESSION;
        $_SESSION[$this->sessionPath][$this->reportName] = $this->filters;
        return $this;
    }
    
    protected function loadFilters()
    {
        global $_SESSION;
        $this->filters = isset($_SESSION[$this->sessionPath][$this->reportName]) ? $_SESSION[$this->sessionPath][$this->reportName] : array();
        return $this;
    }
}
