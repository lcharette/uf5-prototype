<?php declare(strict_types=1);

namespace UserFrosting\System\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class Action
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;
        $this->response = $response;

        return $this->do();
    }

    abstract protected function do(): Response;

    /**
     * @param  array|object|null $data
     * @return Response
     */
    protected function respondWithData($data = null): Response
    {
        $payload = new ActionPayload(200, $data);
        return $this->respond($payload);
    }

    /**
     * @param ActionPayload $payload
     * @return Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);
        $this->response->withHeader('Content-Type', 'application/json');
        return $this->response;
    }
}