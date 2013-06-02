<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\Report;
use Yjv\ReportRendering\IdGenerator\IdGeneratorInterface;

class CallCountIdGenerator implements IdGeneratorInterface
{
    public function getId(Report $report)
    {
        static $count = 0;
        $count++;
        return sha1($count);
    }
}
