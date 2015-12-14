<?php

namespace Ndewez\WebHome\CommonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class MenuCompilerPass.
 */
class MenuCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        // WebHome Auth url in user bar
        if ($container->hasParameter('webhome_auth_url')) {
            $container->getDefinition('webhome.menu.user_bar')->addArgument($container->getParameter('webhome_auth_url'));
        }

        // Listener for build menu
        if (!$container->hasDefinition('webhome.listener.menu')) {
            return;
        }

        $config = $container->getExtensionConfig('ndewez_web_home_common')[0];
        $menuListener = $container->getDefinition('webhome.listener.menu');

        if (isset($config['menu']['getter'])) {
            if (!$container->hasDefinition($config['menu']['getter'])) {
                throw new InvalidArgumentException(sprintf('Service %s doesn\'t exists', $config['menu']['getter']));
            }

            $menuListener->addMethodCall('setGetter', [$container->getDefinition($config['menu']['getter'])]);
        }

        if (isset($config['menu']['builder'])) {
            if (!$container->hasDefinition($config['menu']['builder'])) {
                throw new InvalidArgumentException(sprintf('Service %s doesn\'t exists', $config['menu']['builder']));
            }

            $menuListener->addMethodCall('setBuilderMenuItems', [$container->getDefinition($config['menu']['builder'])]);
        }

        if (isset($config['menu']['builder'])) {
            $menuListener->addMethodCall('setUseSession', [$config['menu']['session']]);
        }
    }
}
