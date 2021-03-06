<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Framework;

use DI\Container;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;
use UserFrosting\Framework\Composer\Installed;
use UserFrosting\Framework\Composer\Package;
use UserFrosting\Framework\Sprinkle\Manager;

class UserFrosting
{
    /**
     * @var Container The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * @var string Root directory of the UserFrosting install.
     */
    protected $rootDir;

    /**
     * @var App
     */
    protected $app;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function run(): void
    {
        $this->setupContainer();
        $this->setupSprinkles();
        $this->setupApp();
        $this->setupRoutes();

        $this->app->run();
    }

    protected function setupContainer(): void
    {
        // First, we create our DI container
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            'router'          => \DI\create(Router::class),
            'sprinkleManager' => \DI\autowire(Manager::class)->method('loadSprinkles'),
            Installed::class  => \DI\autowire(Installed::class)->method('load', $this->rootDir . '/vendor/composer'),
            Package::class    => \DI\autowire(Package::class)->method('load', $this->rootDir),
            'rootDir'         => $this->rootDir,
        ]);

        $this->ci = $containerBuilder->build();
    }

    protected function setupSprinkles(): void
    {
        /** @var Manager */
        $manager = $this->ci->get('sprinkleManager');
        $manager->bootSprinkles();

        $sprinkles = $manager->getSprinkles();
    }

    protected function setupApp(): void
    {
        AppFactory::setContainer($this->ci);
        $this->app = AppFactory::create();
    }

    protected function setupRoutes(): void
    {
        /** @var Router */
        $router = $this->ci->get('router');
        $router->loadRoutes($this->app);
    }
}
