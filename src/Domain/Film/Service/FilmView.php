<?php

namespace App\Domain\Film\Service;

use App\Domain\Film\Repository\FilmRepository;

/**
 * Service.
 */
final class FilmView
{
    /**
     * @var FilmRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FilmRepository $repository
     */
    public function __construct(FilmRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function viewAllMovies(): array
    {

        $movies = $this->repository->selectAllMovies();

        // Tableau qui contient la réponse à retourner à l'usager
        $resultat = [
            "movies" => $movies
        ];

        return $resultat;
    }


}
