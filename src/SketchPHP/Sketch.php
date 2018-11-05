<?php

namespace Sketch;

class Sketch
{
    public static function go($route = NULL)
    {
        is_null($route)
            ? header("Location: " . $_SERVER['REQUEST_URI'])
            : header("Location: $route");

        exit;
    }

    public static function error($msg)
    {
        $_SESSION['sketch']['errors'] = [$msg];
        self::go();
    }
}
