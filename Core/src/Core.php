<?php declare(strict_types=1);

namespace UserFrosting\Sprinkle\Core;

use UserFrosting\Sprinkle\BootDefinition;

class Core extends BootDefinition
{
    public function getPath(): string
    {
        return realpath(__DIR__ . '/..');
    }
}
