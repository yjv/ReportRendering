<?php
namespace Yjv\ReportRendering\Factory;

class BuilderNotReturnedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No builder was returned from any of the types');
    }
}
