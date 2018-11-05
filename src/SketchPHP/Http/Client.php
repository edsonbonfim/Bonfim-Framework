<?php

namespace Sketch\Http;

/**
 * Class Client
 * @package Router
 */
class Client
{
    /**
     * @var mixed
     */
    private $uri;

    /**
     * @var mixed
     */
    private $name;

    /**
     * @var mixed
     */

    private $method;
    /**
     * @var mixed
     */

    private $callback;

    /**
     * @var array
     */
    private $args;

    private $status;

    /**
     * Client constructor.
     * @param array $route
     */
    public function __construct(array $route)
    {
        $this->uri = $route['uri'];
        $this->name = $route['name'];
        $this->method = $route['method'];
        $this->callback = $route['callback'];
        $this->status = $route['status'];
        $this->args = new Request;

        $data = json_decode(file_get_contents('php://input'));

        if (is_object($data)) {
            foreach ($data as $k => $v) {
                @$this->setArg($k, $v);
            }
        }
    }

    /**
     * @return array
     */
    public function getUri(): array
    {
        $uri = explode('/', $this->uri);
        $uri = array_filter($uri);
        $uri = array_values($uri);

        if (count($uri) == 0) {
            return ['index'];
        }

        return $uri;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return array|mixed
     */
    public function getArgs(): Request
    {
        return $this->args;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getArg($key)
    {
        return $this->args[$key];
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setArg(string $key, string $value): void
    {
        $this->args->$key = $value;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }
}
