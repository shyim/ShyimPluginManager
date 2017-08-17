<?php

namespace ShyimPluginManager\Subscriber;

use Composer\Console\Application;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Request_RequestHttp;
use Enlight_Event_EventArgs;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class PluginManagerSubscriber
 * @package ShyimPluginManager\Subscriber
 * @author Soner Sayakci <s.sayakci@gmail.com>
 */
class PluginManagerSubscriber implements SubscriberInterface
{
    /**
     * @var string
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    private $kernelRootDir;

    /**
     * @var string
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    private $cacheDir;

    /**
     * PluginManagerSubscriber constructor.
     * @param string $kernelRootDir
     * @param string $cacheDir
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public function __construct($kernelRootDir, $cacheDir)
    {
        $this->kernelRootDir = $kernelRootDir;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return array
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Backend_PluginInstaller' => 'onDeletePlugin'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return void
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public function onDeletePlugin(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Request_RequestHttp $request */
        $request = $args->get('subject')->Request();

        if ($request->getActionName() !== 'deletePlugin') {
            return;
        }

        $composerLockPath = $this->kernelRootDir . '/custom/composer/composer.lock';

        if (file_exists($composerLockPath)) {
            $lockFile = json_decode(file_get_contents($composerLockPath), true);

            if ($packageName = $this->isPluginInstalledWithComposer($request->getParam('technicalName'), $lockFile)) {
                // Set composer environment variables
                putenv('COMPOSER_HOME=' . $this->cacheDir);

                // Set working directory
                chdir($this->kernelRootDir . '/custom/composer/');

                $composerApp = new Application();
                $composerApp->setAutoExit(false);
                $input = new ArrayInput(array(
                    'command' => 'remove',
                    'packages' => [$packageName]
                ));
                $output = new BufferedOutput();
                $composerApp->run($input, $output);
            }
        }
    }

    /**
     * @param string $pluginName
     * @param array $composerLock
     * @return bool
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    private function isPluginInstalledWithComposer($pluginName, array $composerLock)
    {
        foreach ($composerLock['packages'] as $package) {
            if (isset($package['extra']['installer-name'])) {
                if ($package['extra']['installer-name'] === $pluginName) {
                    return $package['name'];
                }
            }
        }

        return false;
    }
}