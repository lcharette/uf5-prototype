<?php declare(strict_types=1);

use UserFrosting\UserFrosting;

require __DIR__ . '/../vendor/autoload.php';

$uf = new UserFrosting;
$uf->run();
