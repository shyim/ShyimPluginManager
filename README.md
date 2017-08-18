# Packagist Pluginmanager Integration for Shopware

Required Minimum Shopware Version 5.3

This integration is **experimental**. If you found bugs feel free to report or fork and create a pull request :)

# Installation

## Git Version
* Checkout Plugin in `/custom/plugins/ShyimPluginManager`
* Change to Directory and run `composer install` to install the dependencies
* Install the Plugin with the Plugin Manager

# How to add Plugins?

* Add a composer.json file to our Repository. [Example File](https://github.com/shyim/shopware-profiler/blob/master/composer.json)
* Publish your plugin to packagist.org


## Composer-Types

| Type                     | Default Plugin Location                 |
|--------------------------|-----------------------------------------|
| shopware-backend-plugin  | engine/Shopware/Plugins/Local/Backend/  |
| shopware-core-plugin     | engine/Shopware/Plugins/Local/Core/     |
| shopware-frontend-plugin | engine/Shopware/Plugins/Local/Frontend/ |
| shopware-plugin          | custom/plugins/                         |
| shopware-frontend-theme  | themes/Frontend/                        |


# Images
![PluginManager](http://i.imgur.com/IO0XvYP.png)
