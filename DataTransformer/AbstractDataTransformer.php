<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\Config;
use Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\ConfigInterface;
use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDataTransformer implements DataTransformerInterface
{
    protected $config;

    /**
     * @param unknown $config
     */
    public function setConfig($config)
    {
        $this->config = $config instanceof ConfigInterface ? $config : new Config($config);
    }

}
