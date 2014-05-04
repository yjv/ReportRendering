<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 12:18 AM
 */

namespace Yjv\ReportRendering\Data;


class PathStrategyDecider implements StrategyDeciderInterface
{
    protected $paths = array();

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function getStrategy($path, $value)
    {
        return isset($this->paths[$path]) ? $this->paths[$path] : DataEscaperInterface::DEFAULT_STRATEGY;
    }
}