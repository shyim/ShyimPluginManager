<?php

namespace ShyimPluginManager\Bundle\ComposerBundle;

use Composer\Factory;
use Composer\IO\BufferIO;

class ComposerFactory
{
    /**
     * @param string $cacheDir
     * @param string $rootDir
     * @param BufferIO $bufferIO
     * @return mixed
     */
    public static function factory($cacheDir, $rootDir, BufferIO $bufferIO)
    {
        // Set composer environment variables
        putenv('COMPOSER_HOME=' . $cacheDir);

        // Set working directory
        chdir($rootDir);

        return Factory::create($bufferIO, $rootDir . '/composer.json', false);
    }
}