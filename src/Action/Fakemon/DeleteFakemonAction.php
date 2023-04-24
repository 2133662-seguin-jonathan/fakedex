<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\DeleteFakemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteFakemonAction
{
    private $deleteFakemonView;

    public function __construct(DeleteFakemonView $deleteFakemonView)
    {
        $this->deleteFakemonView = $deleteFakemonView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Récupération des parametres
        $fakemonId = $request->getAttribute('id');
        $resultat = $this->deleteFakemonView->deleteFakemon($fakemonId);

        $status = $resultat["status"];

        

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat["data"]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
