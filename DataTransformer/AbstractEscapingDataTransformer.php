<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaper;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Yjv\ReportRendering\DataTransformer\AbstractDataTransformer;

abstract class AbstractEscapingDataTransformer extends AbstractDataTransformer
{
    protected $escaper;
    
    public function __construct(DataEscaperInterface $escaper = null)
    {
        $this->escaper = $escaper ?: new DataEscaper();
    }
    
    protected function escapeValue($value, $strategy)
    {
        if ($strategy === false) {
    
            return $value;
        }
    
        return $this->escaper->escape($value, $strategy);
    }
    
    protected function getEscapeStrategy($path)
    {
        if (!$this->getConfig()->get('escape_values', true)) {
    
            return false;
        }
    
        $escapeStrategies = $this->getConfig()->get('escape_strategies', array());
    
        return isset($escapeStrategies[$path]) ? $escapeStrategies[$path] : DataEscaperInterface::DEFAULT_STRATEGY;
    }
}
