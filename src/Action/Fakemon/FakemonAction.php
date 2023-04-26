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

        $resultat = [
            "erreur" => "Requête invalide"
        ];
        $status = 401;

        $valeurAuth = $request->getHeaderLine("Authorization");
        if (explode(" ", $valeurAuth)[0] == "apikey") {
            $token = explode(" ", $valeurAuth)[1];
            if (base64_encode(base64_decode($token, true)) === $token) {
                $apikey = base64_decode($token);

                $resultatTest = $this->fakemonView->listeFakemon($apikey);
                if (!empty($resultatTest)){
                    $resultat = $resultatTest;
                    $status = 200;
                }
               
            }
        }

        

        

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
