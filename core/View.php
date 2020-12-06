<?php


namespace app\core;


class View
{
    public string $title = '';

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            // name variable as key and assign value to it
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderView($view, $params=[])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layOutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layOutContent);
    }
}