<?php

use App\Model\ShoppingListItem;
use App\RaccoonRouter;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\HttpFoundation\Request;
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
        'debug' => true,
        'cache' => false, // todo: Add caching in production
    ],
);

try {
    $raccoon = new RaccoonRouter();

    $raccoon->addRoute('GET', '/', target: function () use ($twig) {
        echo $twig->render('index.html.twig', [
            'items' => ShoppingListItem::all(['id', 'name', 'quantity']),
        ]);
        exit;
    });

    $raccoon->addRoute('GET', '/db/seed', target: function () {
        ShoppingListItem::seedData(count: 2);

        header('Location: /');
        exit;
    });

    $raccoon->addRoute('GET', '/items/new', function () use ($twig) {
        echo $twig->render("form.html.twig", [
            'item' => new ShoppingListItem(),
        ]);
        exit;
    });

    $raccoon->addRoute('POST', '/items/new', function () use ($twig) {
        $request = Request::createFromGlobals();

        $name = $request->request->get('name');
        $quantity = $request->request->getInt('quantity');

        // todo: validate

        ShoppingListItem::create([
            'name' => $name,
            'quantity' => $quantity,
        ]);

        header('Location: /');
        exit;
    });

    $raccoon->addRoute('GET', '/items/:itemId/edit', function (int $itemId) use ($twig) {
        echo $twig->render("form.html.twig", [
            'item' => ShoppingListItem::findOrFail($itemId),
        ]);
        exit;
    });

    $raccoon->addRoute('POST', '/items/:itemId/edit', function (int $itemId) use ($twig) {
        $request = Request::createFromGlobals();

        $name = $request->request->get('name');
        $quantity = $request->request->getInt('quantity');

        $item = ShoppingListItem::findOrFail($itemId);

        $item->name = $name;
        $item->quantity = $quantity;
        $item->save();

        header('Location: /');
        exit;
    });

    $raccoon->addRoute('GET', '/items/:itemId/delete', function (int $itemId) use ($twig) {
        $item = ShoppingListItem::findOrFail($itemId);

        $item->delete();

        header('Location: /');
        exit;
    });

    $raccoon->matchRoute();
} catch (Throwable $exception) {
    echo $exception->getMessage() . '<br />';
}
