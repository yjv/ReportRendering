<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/11/14
 * Time: 1:16 AM
 */

namespace Yjv\ReportRendering\ReportData;


use Exception;

class DataNotReturnedException extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            'datasource did not return data'
        );
    }

} 