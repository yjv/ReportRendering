<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/8/14
 * Time: 10:08 PM
 */

namespace Yjv\ReportRendering\Renderer;


interface FilterValuesProcessingRendererInterface extends RendererInterface
{
    public function processFilterValues(array $filterValues);
}