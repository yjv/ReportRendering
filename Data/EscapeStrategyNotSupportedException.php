<?php
namespace Yjv\ReportRendering\Data;

class EscapeStrategyNotSupportedException extends \Exception
{
    public function __construct($strategy)
    {

        parent::__construct(sprintf('The escaping strategy "%s" is not supported by this escaper', $strategy));
    }
}
