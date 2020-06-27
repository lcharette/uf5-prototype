<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle;

use Illuminate\Support\Str;
use Psr\Container\ContainerInterface;
use UserFrosting\Support\Exception\FileNotFoundException;
use UserFrosting\Support\Exception\JsonException;
use Composer\Composer;

/**
 * Sprinkle manager class.
 *
 * Manages a collection of loaded Sprinkles for the application.
 * Handles Sprinkle class creation, event subscription, services registration, and resource stream registration.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class SprinkleManager
{
    public function __construct()
    {
    }

    public function loadSprinkles(): void
    {
        $sprinkles = $this->getSprinkles();

        print_r($sprinkles); exit;

        foreach ($sprinkles as $sprinkle) {

            //$class = ...;
        }
    }

    /**
     * @return array<string,string> as SprinkleName => SprinklePath
     */
    public function getSprinkles(): array
    {
       return [
            'userfrosting/core' => $this->getPath('userfrosting/core'),
        ];
    }

    public function getPath(string $sprinkleName): string
    {

        return \UserFrosting\ROOT_DIR . '/app/sprinkles/' . $sprinkleName . '/';
    }
}
