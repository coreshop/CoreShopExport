<?php

namespace CoreShopExport;

use Pimcore\API\Plugin as PluginLib;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    public function init()
    {
        parent::init();

        \Pimcore::getEventManager()->attach('system.console.init', function (\Zend_EventManager_Event $e) {
            /** @var \Pimcore\Console\Application $application */
            $application = $e->getTarget();

            $application->addAutoloadNamespace('CoreShopExport\\Console\\Command', PIMCORE_DOCUMENT_ROOT . '/plugins/CoreShopExport/lib/CoreShopExport/Console/Command');
        });
    }

    public static function install()
    {
        // implement your own logic here
        return true;
    }

    public static function uninstall()
    {
        // implement your own logic here
        return true;
    }

    public static function isInstalled()
    {
        // implement your own logic here
        return true;
    }
}
