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
     * @param array informations du compte
     * @return array L'api key de l'usager
     */
    public function listeType(): array
    {

        $listeFakemon = $this->repository->selectType();

        $resultat = [
            "data"=> $listeFakemon
        ];

        return $resultat;
    }


}
