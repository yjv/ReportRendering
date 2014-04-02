<?php
namespace Yjv\ReportRendering\Filter;

class NativeSessionFilterCollection extends AbstractSessionFilterCollection
{
    protected function syncFilters() 
    {
        global $_SESSION;
        $_SESSION[$this->sessionPath][$this->reportId] = $this->filters;
        return $this;
    }
    
    protected function loadFilters()
    {
        global $_SESSION;
        $this->filters = isset($_SESSION[$this->sessionPath][$this->reportId]) ? $_SESSION[$this->sessionPath][$this->reportId] : array();
        return $this;
    }
}
