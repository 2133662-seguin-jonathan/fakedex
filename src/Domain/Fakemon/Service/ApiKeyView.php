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
     * Sélectionne la clé api relié au compte
     * @param array informations du compte
     * @param int indicateur de si on doit générer un nouvel id
     * @return array L'api key de l'usager
     */
    public function getApiKey(array $compte, int $nouvelle): array
    {
        $apikey = [];

        $apikey = $this->repository->apiKey($compte);
        

        $resultat = [
            "api_key"=>"Compte invalide"
        ];

        if (!empty($apikey)){
            if(password_verify($compte["password"],$apikey["password"])){
                if ($nouvelle == 0){
                    $resultat = [
                        "api_key"=>$apikey["api_key"]
                    ];
                }
               else if ($nouvelle == 1){
                    $resultat = $this->repository->creerCleCompte($compte);
               }
            }
        }
        else {
            $usager = $this->repository->creerUsager($compte);
            if (!empty($usager)){
                $resultat = [
                    "api_key"=>$usager["api_key"]
                ];
            }
        }

        return $resultat;
    }


}
