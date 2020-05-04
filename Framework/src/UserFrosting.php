<?php declare(strict_types=1);

/*
* UserFrosting (http://www.userfrosting.com)
*
* @link      https://github.com/userfrosting/UserFrosting
* @copyright Copyright (c) 2020 Alexander Weissman
* @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
*/

namespace UserFrosting\System;

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;
use UserFrosting\System\Sprinkles\Sprinkle;

class UserFrosting
{
    /**
     * Starts the app in CLI mode and returns an instance to interact with.
     * The `bakery` CLI uses this.
     */
    public static function cli(): UserFrosting
    {

    }

    /**
     * Starts the app in web mode.
     */
    public static function web(): void
    {

    }




    /**
     * @var App The Slim application instance.
     */
    protected $app;

    protected function __construct(bool $cli = false)
    {
        $this->app = AppFactory::create();
    }

    /**
     * Fires off application lifecycle.
     * Once this has returned, the response will have been sent.
     */
    public function start(): void
    {
        $this->setupApp();
        $this->handleRequest();
    }

    public function registerSprinkle(Sprinkle $sprinkle): void
    {

    }

    /**
     * Setup UserFrosting App, load sprinkles, load routes, etc.
     */
    protected function setupApp(): void
    {
        // Error middleware
        // TODO: Move/Remove this, used to assist debugging
        $this->app->addErrorMiddleware(true, false, false);

        // TODO Load configuration

        //
    }

    /**
     * Creates the request and response objects.
     */
    protected function handleRequest(): void
    {
        // Generate request object
        $request = ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        // Generate response
        $response = $this->app->handle($request);

        // Send to client
        (new ResponseEmitter())
            ->emit($response);
    }
}
