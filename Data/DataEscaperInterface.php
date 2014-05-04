<?php
namespace Yjv\ReportRendering\Data;

interface DataEscaperInterface
{
	const DEFAULT_STRATEGY = EscapeStrategies::HTML;
	const DEFAULT_CHARSET = 'UTF-8';
    public function escape($value, $strategy = self::DEFAULT_STRATEGY, array $options = array());
    public function getSupportedStrategies();
}
