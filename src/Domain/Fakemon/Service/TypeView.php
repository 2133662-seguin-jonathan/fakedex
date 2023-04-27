<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class TypeView
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
     * Sélectionne tous les types.
     * @param string la clé api
     * @return array L'api key de l'usager
     */
    public function listeType(string $apikey): array
    {

        $resultat = [];
        $apikeyExiste = $this->repository->chercherUsagerId($apikey);
        if (!empty($apikeyExiste)) {
            $listeType = $this->repository->selectType();
            if (!empty($listeType)){
                $resultat = [
                    "data"=> $listeType
                ];
            }
        }
        

        return $resultat;
    }


}
