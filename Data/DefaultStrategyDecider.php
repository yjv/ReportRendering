<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/3/14
 * Time: 11:40 PM
 */

namespace Yjv\ReportRendering\Data;


class DefaultStrategyDecider implements StrategyDeciderInterface
{
    public function getStrategy($path, $value)
    {
        return DataEscaperInterface::DEFAULT_STRATEGY;
    }
}