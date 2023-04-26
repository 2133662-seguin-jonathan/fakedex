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
     * Sélectionne tous les fakemons de l'usager.
     * @param string la cle api
     * @return array la liste des fakemons
     */
    public function listeFakemon(string $apikey): array
    {
        $resultat = [];

        $idUsager = $this->repository->chercherUsagerId($apikey);
        if (!empty($idUsager)) {
            $listeFakemon = $this->repository->selectFakemon($idUsager["id"]);

            $resultat = [
                "data" => $listeFakemon
            ];
        }


        return $resultat;
    }
}
