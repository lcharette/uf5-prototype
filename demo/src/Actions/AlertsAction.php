<?php declare(strict_types=1);

namespace UserFrosting\Demo\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use UserFrosting\System\Actions\Action;

class AlrtsAction extends Action
{
    function do(): Response
    {
        return $this->respondWithData([]);
    }
}
