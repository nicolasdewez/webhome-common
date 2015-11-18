<?php

namespace Ndewez\WebHome\CommonBundle;

use Ndewez\WebHome\CommonBundle\DependencyInjection\MenuCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class NdewezWebHomeCommonBundle.
 */
class NdewezWebHomeCommonBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MenuCompilerPass());
    }
}
