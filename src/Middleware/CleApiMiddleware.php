<?php
// Source : https://www.slimframework.com/docs/v4/concepts/middleware.html

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Domain\Fakemon\Repository\FakemonRepository;

class CleApiMiddleware
{
     /**
     * @var FakemonRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FakemonRepository $repository
     */
    public function __construct(FakemonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
       
        
        $valeurAuth = $request->getHeaderLine("Authorization");
        if (explode(" ", $valeurAuth)[0] == "apikey") {
            $apikey = explode(" ", $valeurAuth)[1];
            $idUsager = $this->repository->chercherUsagerId($apikey);
            if (empty($idUsager)) {
                $response = new Response();
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(403);
            }
        }
        else {
            $resultat = [
                "erreur" => "Requête invalide"
            ];
            $response = new Response();
            $response->getBody()->write((string)json_encode($resultat));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(401);
        }
        
        $response = $handler->handle($request);

        return $response;
    }
}