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

/**
 * Sprinkle manager class.
 *
 * Manages a collection of loaded Sprinkles for the application.
 * Handles Sprinkle class creation, event subscription, services registration, and resource stream registration.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class SprinkleManagerComposer
{
    public function __construct()
    {
    }
}
