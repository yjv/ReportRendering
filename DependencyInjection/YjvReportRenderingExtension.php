<?php

namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection;

use Symfony\DependencyInjection\ContainerBuilder;
use Symfony\Config\FileLocator;
use Symfony\HttpKernel\DependencyInjection\Extension;
use Symfony\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class YjvReportRenderingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
