<?php

namespace App;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    private static $twig;

    public static function init()
    {
        $loader = new FilesystemLoader(__DIR__ . '/views');
        self::$twig = new Environment($loader);
    }

    public static function render($template, $data = [])
    {
        if (!self::$twig) {
            self::init();
        }
        echo self::$twig->render($template, $data);
    }
}
