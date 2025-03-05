<?php

use App\Raccoon;

require_once __DIR__ . '/../autoload.php';

$raccoon = new Raccoon();
$raccoon->boot();

echo "Hello, world!";
