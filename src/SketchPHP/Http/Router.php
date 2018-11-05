<?php

namespace Sketch\Http;

/**
 * Class Router
 * @package Router
 */
class Router
{
    /**
     * @var array
     */
    private $server;

    /**
     * @var array
     */
    private static $routes = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->server = new Server();
    }

    /**
     * @param array $route
     */
    public function add(array $route): void
    {
        self::$routes[] = new Client($route);
    }

    /**
     * @return null|Client
     */
    public function handle(): ?Client
    {
        foreach (self::$routes as $route) {
            if ($this->checkVerb($route) && $this->checkPath($route)) {
                $this->setArgs($route);
                return $route;
            }
        }
        return null;
    }

    /**
     * @param Client $route
     * @return bool
     */
    private function checkVerb(Client $route): bool
    {
        if ($this->server->getMethod() != $route->getMethod()) {
            return false;
        }

        return true;
    }

    /**
     * @param Client $route
     * @return bool
     */
    private function checkPath(Client $route): bool
    {
        if (count($route->getUri()) != count($this->server->getUri())) {
            return false;
        }

        if (!$this->parsePath($route)) {
            return false;
        }

        for ($i = 0; $i < count($route->getUri()) && count($this->server->getUri()); $i++) {
            if ($route->getUri()[$i] != $this->server->getUri()[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Client $route
     * @return bool
     */
    private function parsePath(Client $route): bool
    {
        $serverUri = $this->server->getUri();
        $routeUri = $route->getUri();

        for ($i = 0; $i < count($routeUri); $i++) {
            $serverUri[$i] = preg_replace('/\@.*/', $this->server->getUri()[$i], $routeUri[$i]);
            if ($serverUri[$i] != $routeUri[$i]) {
                // Regular expression named parameter matching
                if (preg_match('/\@([\w]+):(.*)/', $routeUri[$i], $match)) {
                    if (preg_match('/'.$match[2].'/', $serverUri[$i], $match[2])) {
                        if ($serverUri[$i] != $match[2][0]) {
                            return false;
                        }
                        $route->setArg($match[1], $match[2][0]);
                    } else {
                        return false;
                    }
                } else {
                    $routeUri[$i] = str_replace('@', '', $routeUri[$i]);
                    $route->setArg(str_replace(':', '', $routeUri[$i]), $serverUri[$i]);
                }
            }
        }
            
        $serverUri = implode('/', $serverUri);
        $route->setUri($serverUri);

        return true;
    }

    /**
     * @param Client $route
     */
    private function setArgs(Client $route): void
    {
        foreach ($_POST as $key => $value) {
            $route->setArg($key, $value);
        }
    }
}
