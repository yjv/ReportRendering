<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\ConfigValueRequiredException;

class Config implements ConfigInterface
{
    protected $config = array();

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param unknown $name
     * @param string $default
     */
    public function get($name, $default = null)
    {
        if (!isset($this->config[$name])) {

            if (func_num_args() == 1) {

                throw new ConfigValueRequiredException($name);
            }
        }

        return isset($this->config[$name]) ? $this->config[$name] : $default;
    }
}
