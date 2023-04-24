<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class DeleteFakemonView
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
     * Permet de supprimer un fakemon
     * @param integer l'id du fakemon
     * @return array L'api key de l'usager
     */
    public function deleteFakemon(int $id): array
    {

        $fakemonResultat = $this->repository->deleteFakemon($id);

        $resultat = [
            "data"=> $fakemonResultat["data"],
            "status"=> $fakemonResultat["status"]
        ];

        return $resultat;
    }


}
