<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\AjoutFakemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AjoutFakemonAction
{
    private $ajoutFakemonView;

    public function __construct(AjoutFakemonView $ajoutFakemonView)
    {
        $this->ajoutFakemonView = $ajoutFakemonView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        $resultat = $this->ajoutFakemonView->ajoutFakemon($data);

        $status = 201;


        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
