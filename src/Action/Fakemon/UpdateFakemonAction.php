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
        $status = 403;

        $valeurAuth = $request->getHeaderLine("Authorization");

        $apikey = explode(" ", $valeurAuth)[1];
        // Récupération des parametres
        $fakemonId = $request->getAttribute('id');
        $resultatTest = $this->updateFakemonView->updateFakemon($data, $fakemonId, $apikey);
        if (!empty($resultatTest)) {
            $resultat = $resultatTest["data"];
            $status = $resultatTest["status"];
            // Construit la réponse HTTP
            $response->getBody()->write((string)json_encode($resultat));
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
