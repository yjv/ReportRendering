<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\ReportInterface;

class CallCountIdGenerator implements IdGeneratorInterface
{
    public function getId(ReportInterface $report)
    {
        static $count = 0;
        $count++;
        return sha1($count);
    }
}
