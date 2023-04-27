<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class AjoutFakemonView
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
     * Permet d'ajouter un fakemon à la bd.
     * @param array informations du compte
     * @param string la clé d'api
     * @return array L'api key de l'usager
     */
    public function ajoutFakemon(array $fakemon,string $apikey): array
    {
        $resultat = [];
        $idUsager = $this->repository->chercherUsagerId($apikey);
        if (!empty($idUsager)) {
            $fakemonResultat = $this->repository->insertFakemon($fakemon,$apikey);
            $fakemonResultat["data"]["description"] = stripslashes($fakemonResultat["data"]["description"]);
            $resultat = [
                "data"=> $fakemonResultat
            ];
        }

        return $resultat;
    }


}
