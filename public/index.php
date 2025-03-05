<?php

use App\RaccoonRouter;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../autoload.php';

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$loader = new FilesystemLoader(paths: __DIR__ . '/../templates');
$twig = new Environment(
    loader: $loader,
    options: [
        'cache' => __DIR__ . '/../var/cache',
    ],
);

try {
    $raccoon = new RaccoonRouter();

    // todo: Add routes

    $raccoon->matchRoute();
} catch (Throwable $exception) {
    echo $exception->getMessage() . '<br />';
}
