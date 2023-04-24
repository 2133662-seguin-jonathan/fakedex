<?php

namespace App\Domain\Fakemon\Service;

use App\Domain\Fakemon\Repository\FakemonRepository;

/**
 * Service.
 */
final class ApiKeyView
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
     * Sélectionne tous les films.
     * @param array informations du compte
     * @return array L'api key de l'usager
     */
    public function getApiKey(array $compte): array
    {

        $apikey = $this->repository->apiKey($compte);

        $resultat = [
            "api_key"=>"Compte invalide"
        ];

        if (!empty($apikey)){
            if(password_verify($compte["password"],$apikey["password"])){
                $resultat = [
                    "api_key"=>$apikey["api_key"]
                ];
            }
        }

        return $resultat;
    }


}
