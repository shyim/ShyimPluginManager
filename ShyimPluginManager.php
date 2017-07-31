<?php

namespace ShyimPluginManager;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require(__DIR__ . '/vendor/autoload.php');

/**
 * Class ShyimPluginManager
 * @package ShyimPluginManager
 * @author Soner Sayakci <s.sayakci@gmail.com>
 */
class ShyimPluginManager extends Plugin
{
    /**
     * @param InstallContext $context
     * @return void
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public function install(InstallContext $context)
    {
        $defaultComposer = [
            'extra' => [
                'installer-paths' => [
                    '../plugins/{$name}' => ['type:shopware-plugin'],
                    '../../engine/Shopware/Plugins/Local/Backend/{$name}' => ['type:shopware-backend-plugin'],
                    '../../engine/Shopware/Plugins/Local/Frontend/{$name}' => ['type:shopware-frontend-plugin'],
                    '../../engine/Shopware/Plugins/Local/Core/{$name}' => ['type:shopware-core-plugin'],
                ]
            ]
        ];

        mkdir($this->container->getParameter('kernel.root_dir') . '/custom/composer');

        file_put_contents($this->container->getParameter('kernel.root_dir') . '/custom/composer/composer.json', json_encode($defaultComposer, JSON_PRETTY_PRINT));
    }

    /**
     * @param ContainerBuilder $container
     * @return void
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->setParameter('shyim_pluginmanager.plugin_dir', $this->getPath());
    }
}