<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/10/14
 * Time: 10:35 PM
 */

namespace Yjv\ReportRendering\Event;


use Symfony\Component\EventDispatcher\Event;
use Yjv\ReportRendering\Report\ReportInterface;

class ReportEvent extends Event
{
    protected $report;

    public function __construct(ReportInterface $report)
    {
        $this->report = $report;
    }

    /**
     * @return ReportInterface
     */
    public function getReport()
    {
        return $this->report;
    }
} 