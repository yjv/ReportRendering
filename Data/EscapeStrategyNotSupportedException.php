<?php
namespace Yjv\Bundle\ReportRenderingBundle\Data;

class EscapeStrategyNotSupportedException extends \Exception
{
    public function __construct($strategy)
    {

        parent::__construct(sprintf('The escaping strategy "%s" is not supported by this escaper', $strategy));
    }
}
