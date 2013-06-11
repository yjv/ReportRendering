<?php
namespace Yjv\ReportRendering\Report\Extension\Core;

use Yjv\ReportRendering\Report\Extension\Core\Type\ReportType;

use Yjv\ReportRendering\Factory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    public function loadTypes()
    {
        return array(
            new ReportType()
        );
    }
}
