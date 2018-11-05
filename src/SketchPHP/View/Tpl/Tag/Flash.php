<?php

namespace Sketch\View\Tpl\Tag;

class Flash extends Tag
{
    public function __construct()
    {
        $this->flash();
    }

    public function flash($key)
    {
        if (!isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
        }

        unset($_SESSION['flash'][$key]);

        return $message ?? '';
    }
}
