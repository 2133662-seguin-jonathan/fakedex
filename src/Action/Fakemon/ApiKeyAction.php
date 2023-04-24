<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\ApiKeyView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ApiKeyAction
{
    private $apiKeyview;

    public function __construct(ApiKeyView $apiKeyview)
    {
        $this->apiKeyview = $apiKeyview;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        $resultat = $this->apiKeyview->getApiKey($data);

        $status = 200;

        if ($resultat["api_key"] == "Compte invalide"){
            $status = 403;
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
