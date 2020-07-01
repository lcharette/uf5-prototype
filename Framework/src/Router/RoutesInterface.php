<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Router;

use Slim\App;

/**
 * Routes Interface.
 *
 * This interface helps UF to load routes.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
interface RoutesInterface
{
    public function registerRoutes(App $app): void;
}
