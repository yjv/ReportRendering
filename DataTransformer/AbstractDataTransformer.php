<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\DataTransformer\Config\Config;
use Yjv\ReportRendering\DataTransformer\Config\ConfigInterface;
use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;

abstract class AbstractDataTransformer implements DataTransformerInterface
{
    protected $config;

    /**
     * @param unknown $config
     */
    public function setConfig($config)
    {
        $this->config = $config instanceof ConfigInterface ? $config : new Config($config);
        return $this;
    }

    public function getConfig()
    {
        if (!$this->config) {
            
            $this->setConfig(array());
        }
        
        return $this->config;
    }
}
