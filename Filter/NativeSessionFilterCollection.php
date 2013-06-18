<?php
namespace Yjv\ReportRendering\Filter;

class NativeSessionFilterCollection extends AbstractSessionFilterCollection
{
    protected function syncFilters() 
    {
        $this->filters = isset($_SESSION[$this->sessionPath][$this->reportId]) ? $_SESSION[$this->sessionPath][$this->reportId] : array();
        return $this;
    }
    
    protected function loadFilters()
    {
        $_SESSION[$this->sessionPath][$this->reportId] = $this->filters;
        return $this;
    }
}
