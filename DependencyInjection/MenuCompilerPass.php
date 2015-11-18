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
        if (!$container->hasDefinition('webhome.listener.menu')) {
            return;
        }

        $config = $container->getExtensionConfig('ndewez_web_home_common')[0];

        $menuListener = $container->getDefinition('webhome.listener.menu');

        if (!$container->hasDefinition($config['menu']['getter'])) {
            throw new InvalidArgumentException(sprintf('Service %s doesn\'t exists', $config['menu']['getter']));
        }
        if (!$container->hasDefinition($config['menu']['builder'])) {
            throw new InvalidArgumentException(sprintf('Service %s doesn\'t exists', $config['menu']['builder']));
        }

        $menuListener->addMethodCall('setUseSession', [$config['menu']['session']]);
        $menuListener->addMethodCall('setGetter', [$container->getDefinition($config['menu']['getter'])]);
        $menuListener->addMethodCall('setBuilderMenuItems', [$container->getDefinition($config['menu']['builder'])]);
    }
}
