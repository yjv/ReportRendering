<?php
namespace Yjv\ReportRendering\DataTransformer;

interface DataTransformerInterface
{
    public function transform($data, $originalData);
    public function setConfig($config);
    public function getConfig();
}
