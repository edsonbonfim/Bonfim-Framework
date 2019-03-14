<?php

namespace Sketch;

use EdsonOnildo\Tpl\Tpl;
use EdsonOnildo\Router\{Router, Client};

class Route
{
    private static $router = null;
    private static $status = false;
    private static $match = null;

    private static $methods = ['get', 'post', 'put', 'patch', 'delete', 'options'];

    private static function route(): Router
    {
        if (!isset(self::$router) || is_null(self::$router)) {
            self::$router = new Router;
        }

        return self::$router;
    }

    private static function dispatch(): ?Client
    {
        if (!isset(self::$match) || is_null(self::$match)) {
            self::$match = self::$router->handle();
        }

        return self::$match;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param $callback
     * @return void
     */
    private static function handle(string $method, string $uri, $callback): void
    {
        self::route();

        if (is_string($callback)) {
            $callback = explode('@', $callback);
            $status = true;
        }

        self::$router->add([
            'uri' => $uri,
            'name' => '',
            'method' => $method,
            'callback' => $callback,
            'status' => $status ?? false
        ]);

        $match = self::dispatch();

        if ($match) {

            if ($match->getStatus()) {
                $controller = "\\App\Controller\\" . $match->getCallback()[0];
                $action = $match->getCallback()[1];
                call_user_func_array([new $controller, $action], $match->getArgs());
            } else {
                call_user_func_array($match->getCallback(), $match->getArgs());
            }

            self::$status = true;
            exit;
        }
    }

    /**
     * Metodo magico usado para lidar com as requisicoes:
     * get, post, patch, delete e options
     *
     * @param string $method
     * @param array $params
     *
     * @throws \Exception
     */
    public static function __callStatic(string $method, array $params): void
    {
        if (!in_array($method, self::$methods)) {
            throw new \BadMethodCallException("Call to undefined method " . Route::class . "::$method()");
        }

        array_unshift($params, $method);
        call_user_func_array([Route::class, 'handle'], $params);
    }

    public static function any(string $uri, $callback): void
    {
        foreach (self::$methods as $method) {
            self::handle($method, $uri, $callback);
        }
    }

    public static function view($uri, $view, $assign = [])
    {
        self::handle('get', $uri, function() use ($view, $assign) {
            foreach ($assign as $k => $v) {
                Tpl::assign($k, $v);
            }
            Tpl::render("View/$view");
        });
    }
}
