<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita775fe71ac51d53bcad6804a2c59938f
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita775fe71ac51d53bcad6804a2c59938f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita775fe71ac51d53bcad6804a2c59938f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita775fe71ac51d53bcad6804a2c59938f::$classMap;

        }, null, ClassLoader::class);
    }
}
