<?php

namespace Ndewez\WebHome\CommonBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class NdewezWebHomeCommonExtension.
 */
class NdewezWebHomeCommonExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (true === $config['auth']) {
            $loader->load('security.xml');
        }

        if (isset($config['menu'])) {
            $loader->load('menu.xml');
        }

        if (true === $config['api_client']) {
            $loader->load('api.xml');
        }

        if (true === $config['validator']) {
            $loader->load('validator.xml');
        }
    }
}
