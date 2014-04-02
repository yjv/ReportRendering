<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/29/14
 * Time: 11:24 PM
 */

namespace Yjv\ReportRendering\Renderer\Html\Filter;


interface FormInterface
{
    /**
     * @param array $filters
     * @return array the filter array processed
     */
    public function processFilters(array $filters);

    /**
     * @param array $filters
     * @return self
     */
    public function setFilters(array $filters);
} 