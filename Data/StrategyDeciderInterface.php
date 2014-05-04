<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/3/14
 * Time: 11:39 PM
 */

namespace Yjv\ReportRendering\Data;


interface StrategyDeciderInterface
{
    public function getStrategy($path, $value);
} 