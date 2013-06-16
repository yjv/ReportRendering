<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\ReportInterface;

interface IdGeneratorInterface
{
    public function getId(ReportInterface $report);
}
