<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\Report;

interface IdGeneratorInterface
{
    public function getId(Report $report);
}
