<?php

use App\Model\Product;
use App\Raccoon;
use Illuminate\Database\Capsule\Manager as Capsule;

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

$raccoon = new Raccoon();
$raccoon->boot();

echo "<pre>";
print_r(Product::all()->map(fn(Product $p) => $p->getAttributes()));
echo "</pre>";

echo "Hello, world!";
