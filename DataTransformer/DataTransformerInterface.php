<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

interface DataTransformerInterface
{
    public function transform($data, $originalData);
    public function setConfig($config);
    public function getConfig();
}
