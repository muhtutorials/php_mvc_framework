<?php


namespace app\core;


use app\core\exceptions\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException;
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            // create an instance of a class to use $this inside of it
            $controller = new $callback[0];
            Application::$app->controller = $controller;
            // set action in the controller
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
        }
        // call class method ($callback is an array [$ClassName, 'methodName'])
        return call_user_func($callback, $this->request, $this->response);
    }
}