<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/3/14
 * Time: 11:26 PM
 */

namespace Yjv\ReportRendering\Data;


class IdentityDataEscaper implements DataEscaperInterface
{

    public function escape(
        $value,
        $strategy = self::DEFAULT_STRATEGY,
        array $options = array()
    ) {
        return $value;
    }

    public function getSupportedStrategies()
    {
        return EscapeStrategies::$allStrategies;
    }
}