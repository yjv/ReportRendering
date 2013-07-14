<?php
namespace Yjv\ReportRendering\Factory\Extension;

use Yjv\ReportRendering\Factory\AbstractExtension;

class PreloadedExtension extends AbstractExtension
{
    protected $passedTypes;
    protected $passedTypeExtensions;
    
    public function __construct(array $types, array $typeExtensions)
    {
        $this->passedTypes = $types;
        $this->passedTypeExtensions = $typeExtensions;
    }
    
    protected function loadTypes()
    {
        return $this->passedTypes;
    }
    
    protected function loadTypeExtensions()
    {
        return $this->passedTypeExtensions;
    }
}
