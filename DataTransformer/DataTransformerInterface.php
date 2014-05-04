<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaperInterface;
use Yjv\ReportRendering\Data\StrategyDeciderInterface;

interface DataTransformerInterface
{
    /**
     * @param mixed $data
     * @param mixed $originalData
     * @return mixed
     */
    public function transform($data, $originalData);

    /**
     * @param DataEscaperInterface $escaper
     * @return self
     */
    public function setEscaper(DataEscaperInterface $escaper);

    /**
     * @param StrategyDeciderInterface $decider
     * @return self
     */
    public function setEscapeStrategyDecider(StrategyDeciderInterface $decider);
}
