<?php
namespace Yjv\ReportRendering\Datasource;

class ValidDatasourceNotReturnedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('No valid datasource was returned from the builder\'s constructor callback.');
    }
}
