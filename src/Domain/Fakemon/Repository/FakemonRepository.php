<?php

namespace App\Domain\Fakemon\Repository;

use PDO;

/**
 * Repository.
 */
class FakemonRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sélectionne l'api du compte fourni
     * 
     * @param array les informations du compte
     * @return DataResponse
     */
    public function apiKey($compte): array
    {
        $sql = "SELECT api_key, password FROM usager WHERE username = :username ;";

        $params = [
            "username" => $compte["username"] ?? null
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        
        
        return $result[0] ?? [];
    }

    /**
     * Sélectionne la liste des fakemons
     * 
     * @return DataResponse
     */
    public function selectFakemon(): array
    {
        $sql = "SELECT * FROM creature ;";


        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        
        
        return $result ?? [];
    }


    /**
     * Sélectionne la liste des ftypes
     * 
     * @return DataResponse
     */
    public function selectType(): array
    {
        $sql = "SELECT * FROM type ORDER BY nom ;";


        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        
        
        return $result ?? [];
    }

}

