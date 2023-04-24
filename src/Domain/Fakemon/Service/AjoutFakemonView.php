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
     * @return array L'api key de l'usager
     */
    public function ajoutFakemon(array $fakemon): array
    {

        $fakemonResultat = $this->repository->insertFakemon($fakemon);

        $resultat = [
            "data"=> $fakemonResultat
        ];

       

        return $resultat;
    }


}
