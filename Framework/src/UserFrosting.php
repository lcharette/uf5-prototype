<?php
declare(strict_types=1);

namespace UserFrosting;

use DI\Container;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Sprinkle\SprinkleManagerComposer;

class UserFrosting
{
    /**
     * @var Container The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * @var App
     */
    protected $app;

    public function __construct()
    {
        $this->setupContainer();
        $this->setupSprinkles();
        $this->setupApp();
        $this->setupRoutes();
    }

    public function run(): void
    {
        $this->app->run();
    }

    protected function setupContainer(): void
    {
        // First, we create our DI container
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            'router'    => \DI\create(Router::class),
            'sprinkles' => \DI\create(SprinkleManagerComposer::class),
        ]);

        $this->ci = $containerBuilder->build();
    }

    protected function setupSprinkles(): void
    {
        /** @var SprinkleManagerComposer */
        $sprinkles = $this->ci->get('sprinkles');


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
