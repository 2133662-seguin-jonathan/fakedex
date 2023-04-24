<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\UpdateFakemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateFakemonAction
{
    private $updateFakemonView;

    public function __construct(UpdateFakemonView $updateFakemonView)
    {
        $this->updateFakemonView = $updateFakemonView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        // Récupération des parametres
        $fakemonId = $request->getAttribute('id');

        $resultat = $this->updateFakemonView->updateFakemon($data,$fakemonId);

        $status = $resultat["status"];

        $resultatJSON = [
            "data"=>$resultat["data"]
        ];

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultatJSON));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
