<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\ReportInterface;

class ConstantValueIdGenerator implements IdGeneratorInterface
{
    protected $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }
    
    public function getId(ReportInterface $report)
    {
        return $this->id;
    }
}
