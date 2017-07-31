<?php

use Shopware\Bundle\PluginInstallerBundle\Context\ListingRequest;
use Shopware\Bundle\PluginInstallerBundle\Service\InstallerService;
use Shopware\Bundle\PluginInstallerBundle\Service\PluginLocalService;
use Symfony\Component\Console\Input\ArrayInput;

class Shopware_Controllers_Backend_Composer extends Shopware_Controllers_Backend_ExtJs
{
    /**
     * @return void
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public function listAction()
    {
        $plugins = $this->get('shopware_composer.service.plugin_list')->getPluginList();
        $this->View()->total = count($plugins);
        $this->View()->data = $plugins;
    }

    public function installAction()
    {
        // Set composer environment variables
        putenv('COMPOSER_HOME=' . $this->container->getParameter('composer.cache_dir'));

        // Set working directory
        chdir($this->container->getParameter('kernel.root_dir') . '/custom/composer/');

        $packageName = $this->Request()->getParam('plugin');
        $composerApp = new \Composer\Console\Application();
        $composerApp->setAutoExit(false);
        $input = new ArrayInput(array(
            'command' => 'require',
            'packages' => [$packageName . ':' . $this->Request()->getParam('version')]
        ));
        $output = new \Symfony\Component\Console\Output\BufferedOutput();
        $composerApp->run($input, $output);
        /** @var InstallerService $pluginManager */
        $pluginManager = $this->get('shopware_plugininstaller.plugin_manager');
        $pluginManager->refreshPluginList();
        $context = new ListingRequest(
            $this->getLocale(),
            $this->getVersion(),
            0,
            null,
            $this->Request()->getParam('filter', []),
            $this->getListingSorting()
        );
        /** @var PluginLocalService $localService */
        $localService = $this->get('shopware_plugininstaller.plugin_service_local');
        $plugins = $localService->getListing($context)->getPlugins();
        /** @var \Shopware\Bundle\PluginInstallerBundle\Struct\PluginStruct $plugin */
        foreach ($plugins as $plugin) {
            if ($plugin->getTechnicalName() == $this->Request()->getParam('installName')) {
                $this->View()->success = true;
                $this->View()->data = $plugin;
            }
        }
    }

    /**
     * @return string
     */
    private function getLocale()
    {
        return Shopware()->Container()->get('Auth')->getIdentity()->locale->getLocale();
    }

    /**
     * @return string
     */
    private function getVersion()
    {
        return Shopware::VERSION;
    }

    private function getListingSorting()
    {
        $prioritySorting = [
            ['property' => 'active', 'direction' => 'DESC'],
            ['property' => 'installation_date IS NULL', 'direction' => 'ASC']
        ];
        $fallbackSorting = [
            ['property' => 'installation_date', 'direction' => 'DESC']
        ];
        $customSorting = [];
        foreach ($this->Request()->getParam('sort', []) as $sortData) {
            if ($sortData['property'] == 'groupingState') {
                continue;
            }
            $sortData['property'] = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $sortData['property']));
            $customSorting[] = $sortData;
        }
        return array_merge($prioritySorting, $customSorting, $fallbackSorting);
    }
}