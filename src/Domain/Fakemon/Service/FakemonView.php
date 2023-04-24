<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class FakemonView
{
    /**
     * @var FakemonRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FakemonRepository $repository
     */
    public function __construct(FakemonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sélectionne tous les fakemons.
     * @param array informations du compte
     * @return array L'api key de l'usager
     */
    public function listeFakemon(): array
    {

        $listeFakemon = $this->repository->selectFakemon();

        $resultat = [
            "data"=> $listeFakemon
        ];

        return $resultat;
    }


}
