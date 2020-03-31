<?php declare(strict_types=1);

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\System\Router;

use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;
use Slim\App;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Interfaces\RouteInterface;
use Slim\Routing\RouteCollector;

/**
 * Router.
 *
 * This class extends Slim's router, to permit overriding of routes with the same signature.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class Router extends RouteCollector implements RouteCollectorInterface
{
    /**
     * @var string[] a reverse lookup of route identifiers, indexed by route signature
     */
    protected $identifiers;

    /**
     * Add route.
     *
     * @param string[] $methods Array of HTTP methods
     * @param string   $pattern The route pattern
     * @param callable $handler The route callable
     *
     * @throws InvalidArgumentException if the route pattern isn't a string
     *
     * @return RouteInterface
     */
    public function map(array $methods, string $pattern, $handler)
    {
        if (!is_string($pattern)) {
            throw new InvalidArgumentException('Route pattern must be a string');
        }

        // Prepend parent group pattern(s)
        if ($this->routeGroups) {
            $pattern = $this->processGroups() . $pattern;
        }

        // Determine route signature
        $signature = implode('-', $methods) . '-' . $pattern;

        // If a route with the same signature already exists, then we must replace it
        if (isset($this->identifiers[$signature])) {
            $route = new \Slim\Routing\Route(
                $methods,
                $pattern,
                $handler,
                $this->responseFactory,
                $this->callableResolver,
                $this->container,
                $this->defaultInvocationStrategy,
                $this->routeGroups,
                str_replace('route', '', $this->identifiers[$signature])
            );
        } else {
            $route = $this->createRoute($methods, $pattern, $handler);
        }

        $this->routes[$route->getIdentifier()] = $route;

        // Record identifier in reverse lookup array
        $this->identifiers[$signature] = $route->getIdentifier();

        $this->routeCounter++;

        return $route;
    }

    /**
     * Delete the cache file.
     *
     * @return bool true/false if operation is successfull
     */
    public function clearCache()
    {
        // Get Filesystem instance
        $fs = new Filesystem();

        // Make sure file exist and delete it
        if ($fs->exists($this->cacheFile)) {
            return $fs->delete($this->cacheFile);
        }

        // It's still considered a success if file doesn't exist
        return true;
    }

    /**
     * Load all avaialbe routes.
     *
     * @param App $slimApp
     */
    public function loadRoutes(App $slimApp)
    {
        // Since routes aren't encapsulated in a class yet, we need this workaround :(
        global $app;
        $app = $slimApp;

        $ci = $app->getContainer();

        // Reverse the list, so the lower priority are required first
        $routeFiles = array_reverse($ci->locator->listResources('routes://', true, false));
        foreach ($routeFiles as $routeFile) {
            require $routeFile;
        }
    }
}
