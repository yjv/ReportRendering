<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/13/14
 * Time: 9:56 PM
 */

namespace Yjv\ReportRendering;


use Yjv\ReportRendering\Report\ReportFactory;
use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    /**
     * @return ReportFactoryBuilder
     */
    public static function createReportFactoryBuilder()
    {
        return ReportFactoryBuilder::create();
    }

    /**
     * @return ReportFactory
     */
    public static function createReportFactory()
    {
        return static::createReportFactoryBuilder()->build();
    }
} 