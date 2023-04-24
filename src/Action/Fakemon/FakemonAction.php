<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\FakemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FakemonAction
{
    private $fakemonView;

    public function __construct(FakemonView $fakemonView)
    {
        $this->fakemonView = $fakemonView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        $resultat = $this->fakemonView->listeFakemon();

        $status = 200;

        

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
