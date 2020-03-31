<?php declare(strict_types=1);

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\System\Router;

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