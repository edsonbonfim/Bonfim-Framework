<?php

namespace Sketch\Http;

use Sketch\View\Tpl;

/**
 * Class Route
 * @package Router
 */
/**
 * Class Route
 * @package Router
 */
/**
 * Class Route
 * @package Router
 */
class Route
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var bool
     */
    private $status = false;

    /**
     * @var
     */
    private static $route;

    /**
     * @var null
     */
    private static $match = null;

    /**
     * @var null
     */
    private static $defaultCallback = null;

    /**
     * Route constructor.
     */
    private function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Route destructor.
     */
    public function __destruct()
    {
        if (!$this->status) {
            $callback = self::$defaultCallback;
            if (is_callable($callback)) {
                $callback();
                unset($_SESSION['sketch']['errors']);
                exit;
            }
        }
    }

    /**
     * @return Route
     */
    private static function route(): Route
    {
        if (!isset(self::$route) || is_null(self::$route)) {
            self::$route = new Route;
        }

        return self::$route;
    }

    /**
     * @return null|Client
     */
    private static function dispatch(): ?Client
    {
        if (!isset(self::$match) || is_null(self::$match)) {
            self::$match = self::route()->router->handle();
        }

        return self::$match;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param $callback
     * @return void
     */
    private function handle(string $method, string $uri, $callback): void
    {
        if (is_string($callback)) {
            $callback = explode('@', $callback);
            $status = true;
        }

        $this->router->add([
            'uri' => $uri,
            'name' => '',
            'method' => $method,
            'callback' => $callback,
            'status' => $status ?? false
        ]);

        $match = $this->dispatch();

        if ($match) {

            if ($match->getStatus()) {
                $controller = "\\App\Controller\\" . $match->getCallback()[0];
                $controller = new $controller;
                $action = $match->getCallback()[1];
                $controller->$action($match->getArgs());
            } else {
                $callback = $match->getCallback();
                $callback($match->getArgs());
            }

            $this->status = true;
            unset($_SESSION['sketch']['errors']);
            exit;
        }
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function get(string $uri, $callback): void
    {
        self::route()->handle('get', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function post(string $uri, $callback): void
    {
        self::route()->handle('post', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function put(string $uri, $callback): void
    {
        self::route()->handle('put', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function patch(string $uri, $callback): void
    {
        self::route()->handle('patch', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function delete(string $uri, $callback): void
    {
        self::route()->handle('delete', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function options(string $uri, $callback): void
    {
        self::route()->handle('options', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     */
    public static function any(string $uri, $callback): void
    {
        $methods = ['get', 'post', 'put', 'patch', 'delete', 'options'];
        self::match($methods, $uri, $callback);
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param $callback
     */
    public static function match(array $methods, string $uri, $callback): void
    {
        foreach ($methods as $method) {
            self::route()->handle($method, $uri, $callback);
        }
    }

    public static function view($uri, $view, $assign = [])
    {
        self::get($uri, function() use ($view, $assign) {
            foreach ($assign as $k => $v) {
                Tpl::assign($k, $v);
            }
            Tpl::render("View/$view");
        });
    }

    /**
     * @param $callback
     */
    public static function default($callback): void
    {
        self::$defaultCallback = $callback;
    }

    public static function go($route = NULL)
    {
        is_null($route)
            ? header("Location: " . $_SERVER['REQUEST_URI'])
            : header("Location: $route");

        exit;
    }
}
