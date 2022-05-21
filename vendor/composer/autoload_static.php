<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit13b0d5a568edb4a09bb4319dd9e04cc2
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit13b0d5a568edb4a09bb4319dd9e04cc2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit13b0d5a568edb4a09bb4319dd9e04cc2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit13b0d5a568edb4a09bb4319dd9e04cc2::$classMap;

        }, null, ClassLoader::class);
    }
}
