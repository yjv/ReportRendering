<?php
namespace Yjv\ReportRendering\Data;

interface DataEscaperInterface
{
    public function escape($strategy, $value);
    public function getSupportedStrategies();
}
