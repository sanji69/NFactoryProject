<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit92d8f2be4d0650a6ab128bf18e7a3117
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit92d8f2be4d0650a6ab128bf18e7a3117::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit92d8f2be4d0650a6ab128bf18e7a3117::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
