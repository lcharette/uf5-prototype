<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\System\Controller;

/**
 * CoreController Class.
 *
 * Implements some common sitewide routes.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 *
 * @see http://www.userfrosting.com/navigating/#structure
 */
class CoreController extends Controller
{
    /**
     * Renders the default home page for UserFrosting.
     * By default, this is the page that non-authenticated users will first see when they navigate to your website's root.
     * Request type: GET.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    public function pageIndex(Request $request, Response $response, $args)
    {
        return $this->ci->view->render($response, 'pages/index.html.twig');
    }
}
