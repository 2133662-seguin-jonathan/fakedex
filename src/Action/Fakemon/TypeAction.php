<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\TypeView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TypeAction
{
    private $typeView;

    public function __construct(TypeView $typeView)
    {
        $this->typeView = $typeView;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $status = 403;

        $valeurAuth = $request->getHeaderLine("Authorization");

        $apikey = explode(" ", $valeurAuth)[1];

        $resultatTest = $this->typeView->listeType($apikey);
        if (!empty($resultatTest)) {
            $resultat = $resultatTest;
            $status = 200;
            // Construit la réponse HTTP
            $response->getBody()->write((string)json_encode($resultat));
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
