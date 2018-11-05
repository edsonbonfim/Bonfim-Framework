<?php

namespace Sketch\Http;

/**
 * Class Server
 * @package Router
 */
class Server
{
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return array
     */
    public function getUri(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $uri = array_filter($uri);
        $uri = array_values($uri);

        if (count($uri) == 0) {
            return ['index'];
        }

        return $uri;
    }
}
