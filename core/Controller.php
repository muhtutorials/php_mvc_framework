<?php


namespace app\core;


use app\core\middleware\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    protected array $middleWare = [];
    public string $action = '';

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params=[])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleWare[] = $middleware;
    }

    public function getMiddleware(): array {
        return $this->middleWare;
    }
}