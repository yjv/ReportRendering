<?php
namespace Yjv\ReportRendering\IdGenerator;

use Yjv\ReportRendering\Report\ReportInterface;

class CallCountIdGenerator implements IdGeneratorInterface
{
    protected $prefix;
    protected $count = 0;
    
    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
    }
    
    public function getId(ReportInterface $report)
    {
        return sha1($this->prefix . (string)++$this->count);
    }
    
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }
    
    public function getPrefix()
    {
        return $this->prefix;
    }
}
