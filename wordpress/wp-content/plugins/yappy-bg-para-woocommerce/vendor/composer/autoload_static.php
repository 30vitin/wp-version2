<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab240f9c5ae33a1a9b81e9e6ef816641
{
    public static $files = array (
        '689b08b7620712b04324ecd7ed167c6b' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p10.php',
    );

    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab240f9c5ae33a1a9b81e9e6ef816641::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab240f9c5ae33a1a9b81e9e6ef816641::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
