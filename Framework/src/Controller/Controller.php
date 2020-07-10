<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Framework\Controller;

use Psr\Container\ContainerInterface;

/**
 * Controller Class.
 *
 * Basic controller class, that imports the entire DI container for easy access to services.
 * Your controller classes may extend this controller class.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 *
 * @see http://www.userfrosting.com/navigating/#structure
 */
class Controller
{
    /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * Constructor.
     *
     * @param ContainerInterface $ci The global container object, which holds all your services.
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }
}
