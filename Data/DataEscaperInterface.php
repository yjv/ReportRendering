<?php
namespace Yjv\ReportRendering\Data;

interface DataEscaperInterface
{
	const DEFAULT_STRATEGY = 'html';
	const DEFAULT_CHARSET = 'UTF-8';
    public function escape($value, $strategy = DataEscaperInterface::DEFAULT_STRATEGY, $charset = DataEscaperInterface::DEFAULT_CHARSET);
    public function getSupportedStrategies();
}
