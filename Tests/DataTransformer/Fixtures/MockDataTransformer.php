<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 2:18 AM
 */

namespace Yjv\ReportRendering\Tests\DataTransformer\Fixtures;


use Yjv\ReportRendering\DataTransformer\AbstractDataTransformer;

class MockDataTransformer extends AbstractDataTransformer
{
    /**
     * @param mixed $data
     * @param mixed $originalData
     * @return mixed
     */
    public function transform($data, $originalData)
    {
    }
}