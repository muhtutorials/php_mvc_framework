<?php


namespace app\core;

use app\core\db\Database;
use app\core\db\DBModel;


class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Request $request;
    public Response $response;
    public Session $session;
    public Router $router;
    // set in case some not found page is accessed
    public ?Controller $controller = null;
    public Database $db;
    public ?UserModel $user;
    public string $userClass;
    // set in case some not found page is accessed
    public string $layout = 'main';
    public View $view;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];
        $this->view = new View();

        // it's run on every request
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            // without this line response status code is 200
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('error', ['exception' => $e]);
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}