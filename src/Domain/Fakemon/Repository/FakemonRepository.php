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
            "username" => $compte["username"] ?? ""
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        
        
        return $result[0] ?? [];
    }

     /**
     * Sélectionne le fakemon de l'id en question
     * 
     * @param array les informations du compte
     * @return DataResponse
     */
    public function afficherFakemonById($id): array
    {
        $sql = "SELECT * FROM creature WHERE id = :id ;";

        $params = [
            "id" => $id
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        
        
        return $result[0] ?? [];
    }

    /**
     * Permet d'insert un nouveau fakemon
     * 
     * @param array les informations du fakemon
     * @return DataResponse
     */
    public function insertFakemon($fakemon): array
    {
        $sql = "INSERT INTO creature (nom,id_type1,id_type2,hp,atk,def,sp_atk,sp_def,speed,description) 
        VALUES (:nom,:id_type1,:id_type2,:hp,:atk,:def,:sp_atk,:sp_def,:speed,:description);";

        $params = [
            "nom"=> $fakemon["nom"] ?? "",
            "id_type1"=> $fakemon["id_type1"] ?? 1,
            "id_type2"=> $fakemon["id_type2"] ?? 1,
            "hp" => $fakemon["hp"] ?? 0,
            "atk"=> $fakemon["atk"] ?? 0,
            "def"=> $fakemon["def"] ?? 0,
            "sp_atk"=> $fakemon["sp_atk"] ?? 0,
            "sp_def"=> $fakemon["sp_def"] ?? 0,
            "speed"=> $fakemon["speed"] ?? 0,
            "description"=> $fakemon["description"] ?? ""
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $idFakemon = $this->connection->lastInsertId();
        $resultat = $this->afficherFakemonById($idFakemon);
        
        return $resultat ?? [];
    }


     /**
     * Permet de supprimer un fakemon.
     * 
     * @param int l'id du fakemon
     * @return DataResponse
     */
    public function deleteFakemon($id): array
    {
        $test = $this->afficherFakemonById($id);

        if (empty($test)){
           $resultat = [
            "data"=> [],
            "status"=>404
           ];
            
            return $resultat ?? [];
        }
        else {
            $sql = "DELETE FROM creature WHERE id=:id ;";
    
            $params = [
                "id"=> $id
            ];
    
            $query = $this->connection->prepare($sql);
            $query->execute($params);

            $resultat = [
                "data"=>$test,
                "status"=> 200
            ];
            
            return $resultat ?? [];
        }
    }


    /**
     * Permet de modifier un fakemon
     * 
     * @param array les informations du fakemon
     * @param int l'id du fakemon
     * @return DataResponse
     */
    public function updateFakemon(array $fakemon,int $id): array
    {

        $test = $this->afficherFakemonById($id);

        if (empty($test)){
            $sql = "INSERT INTO creature (nom,id_type1,id_type2,hp,atk,def,sp_atk,sp_def,speed,description) 
            VALUES (:nom,:id_type1,:id_type2,:hp,:atk,:def,:sp_atk,:sp_def,:speed,:description);";
    
            $params = [
                "nom"=> $fakemon["nom"] ?? "",
                "id_type1"=> $fakemon["id_type1"] ?? 1,
                "id_type2"=> $fakemon["id_type2"] ?? 1,
                "hp" => $fakemon["hp"] ?? 0,
                "atk"=> $fakemon["atk"] ?? 0,
                "def"=> $fakemon["def"] ?? 0,
                "sp_atk"=> $fakemon["sp_atk"] ?? 0,
                "sp_def"=> $fakemon["sp_def"] ?? 0,
                "speed"=> $fakemon["speed"] ?? 0,
                "description"=> $fakemon["description"] ?? ""
            ];
    
            $query = $this->connection->prepare($sql);
            $query->execute($params);
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $idFakemon = $this->connection->lastInsertId();
            $resultat = [
                "data"=>$this->afficherFakemonById($idFakemon),
                "status"=> 201
            ];
            
            return $resultat ?? [];
        }
        else {
            $sql = "UPDATE creature
             SET nom=:nom,id_type1=:id_type1,id_type2=:id_type2,hp=:hp,atk=:atk,def=:def,sp_atk=:sp_atk,sp_def=:sp_def,speed=:speed,description=:description
              WHERE id = :id";
    
            $params = [
                "id"=> $id,
                "nom"=> $fakemon["nom"] ?? "",
                "id_type1"=> $fakemon["id_type1"] ?? 1,
                "id_type2"=> $fakemon["id_type2"] ?? 1,
                "hp" => $fakemon["hp"] ?? 0,
                "atk"=> $fakemon["atk"] ?? 0,
                "def"=> $fakemon["def"] ?? 0,
                "sp_atk"=> $fakemon["sp_atk"] ?? 0,
                "sp_def"=> $fakemon["sp_def"] ?? 0,
                "speed"=> $fakemon["speed"] ?? 0,
                "description"=> $fakemon["description"] ?? ""
            ];
    
            $query = $this->connection->prepare($sql);
            $query->execute($params);

            $resultat = [
                "data"=>$this->afficherFakemonById($id),
                "status"=> 200
            ];
            
            return $resultat ?? [];
        }
       
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

