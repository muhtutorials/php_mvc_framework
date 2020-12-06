<?php
// index.php should be in a separate folder from composer.json and other files which contain sensitive data
// if index.php is in the same folder for example with composer.json user can type in www.whatever.com/composer.json
// and access it

use app\models\User;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ . '/../vendor/autoload.php';

// composer require vlucas/phpdotenv - installs the package which loads environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
    'userClass' => User::class
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
// should be post method to be secure
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/profile', [AuthController::class, 'profile']);

$app->run();
