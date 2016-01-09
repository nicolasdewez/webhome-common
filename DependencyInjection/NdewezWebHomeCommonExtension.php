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

        $loader->load('services.xml');
        $loader->load('listeners.xml');

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

        // Update ApiGetConnectedUserListener with config
        if (isset($config['api_user_connected'])) {
            $this->updateApiGetConnectedUserListener($config['api_user_connected'], $container);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function updateApiGetConnectedUserListener(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('webhome.listener.api_user_connected');
        $definition
            ->addArgument($config['session_key'])
            ->addArgument($config['access_token_key']['header'])
            ->addArgument($config['access_token_key']['get'])
        ;

        foreach($config['required_paths'] as $requiredPath) {
            $definition->addMethodCall('addRequiredPath', [$requiredPath]);
        }
        
        foreach($config['optional_paths'] as $optionalPath) {
            $definition->addMethodCall('addOptionalPath', [$optionalPath]);
        }
    }
}
