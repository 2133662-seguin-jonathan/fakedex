<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class UpdateFakemonView
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
     * Permet de modifier un fakemon.
     * @param array informations du fakemon
     * @param int l'id du fakemon
     * @param string la clé api
     * @return array L'api key de l'usager
     */
    public function updateFakemon(array $fakemon, int $idFakemon, string $apikey): array
    {
        $resultat = [];
        $idUsager = $this->repository->chercherUsagerId($apikey);
        if (!empty($idUsager)) {
            $fakemonResultat = $this->repository->updateFakemon($fakemon, $idFakemon, $apikey,$idUsager["id"]);
            if (!empty($fakemonResultat)){
                $resultat = [
                    "data" => $fakemonResultat["data"],
                    "status" => $fakemonResultat["status"]
                ];
            }
        }


        return $resultat;
    }
}
