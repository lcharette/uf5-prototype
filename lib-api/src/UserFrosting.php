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

class UserFrosting
{
    /**
     * @var App The Slim application instance.
     */
    protected $app;

    public function __construct(bool $cli = false)
    {
        $this->app = AppFactory::create();
        $this->app->addErrorMiddleware(true, false, false);

        // Generate request object
        $request = ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        // Generate response
        $response = $this->app->handle($request);

        // Send to client
        (new ResponseEmitter())
            ->emit($response);
    }

    public function registerSprinkle(): void
    {

    }
}
