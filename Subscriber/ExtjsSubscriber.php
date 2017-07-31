<?php

namespace ShyimPluginManager\Subscriber;

use Enlight\Event\SubscriberInterface;

class ExtjsSubscriber implements SubscriberInterface
{
    /**
     * @var
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    private $viewDir;

    /**
     * ExtjsSubscriber constructor.
     * @param $viewDir
     */
    public function __construct($viewDir)
    {
        $this->viewDir = $viewDir;
    }

    /**
     * {@inheritdoc}
     * @author Soner Sayakci <s.sayakci@gmail.com>
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_PluginManager' => 'onPluginManager'
        ];
    }

    public function onPluginManager(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_PluginManager $subject */
        $subject = $args->getSubject();

        if ($subject->Request()->getActionName() === 'load') {
            $subject->View()->addTemplateDir($this->viewDir);
            $subject->View()->extendsTemplate('composer/app.js');
        }
    }
}