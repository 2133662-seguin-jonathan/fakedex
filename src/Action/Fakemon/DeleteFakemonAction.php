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
        $status = 403;

        $valeurAuth = $request->getHeaderLine("Authorization");
       
        $apikey = explode(" ", $valeurAuth)[1];
        $fakemonId = $request->getAttribute('id');

        $resultatTest = $this->deleteFakemonView->deleteFakemon($fakemonId, $apikey);
        if (!empty($resultatTest)) {
            $resultat =  $resultatTest["data"];
            $status = $resultatTest["status"];
            // Construit la réponse HTTP
            $response->getBody()->write((string)json_encode($resultat));
        }
        

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
