<?php
namespace Yjv\Bundle\ReportRenderingBundle\Data;

interface DataEscaperInterface
{
    public function escape($strategy, $value);
    public function getSupportedStrategies();
}
