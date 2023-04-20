<?php

namespace App\Action\Film;

use App\Domain\Film\Service\FilmView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilmViewAction
{
    private $movieView;

    public function __construct(FilmView $movieView)
    {
        $this->movieView = $movieView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des parametres
        $userId = $request->getAttribute('id');

        $resultat = $this->movieView->viewAllMovies();

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
