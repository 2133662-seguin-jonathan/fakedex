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
     * Permet de générer un uuid.
     * Source: https://www.uuidgenerator.net/dev-corner/php
     * 
     * @return string un uuid.
     */
    private function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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
            "username" => htmlspecialchars($compte["username"],ENT_QUOTES) ?? ""
        ];
        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $apikey = $result[0] ?? [];

        if (!empty($apikey)) {
            if ($apikey["api_key"] == "") {
                $resultat = $this->creerCleCompte($compte);
                $apikey["api_key"] = $resultat["api_key"];
            }
        } else {
            $apikey = [];
        }

        return $apikey;
    }

    /**
     * Créer une clé api à un compte.
     * 
     * @param array les informations du compte.
     * @return DataResponse
     */
    public function creerCleCompte(array $compte): array
    {
        $cleNouv = $this->guidv4();

        $sql = "UPDATE usager SET api_key = :apikey WHERE username = :username ;";

        $params = [
            "apikey" => $cleNouv,
            "username" => htmlspecialchars($compte["username"],ENT_QUOTES)
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = [
            "api_key" => $cleNouv
        ];


        return $result;
    }

    /**
     * Permet d'inserer un nouvel usager.
     * 
     * @param array les informations de l'usager
     * @return DataResponse
     */
    public function creerUsager($compte): array
    {
        $sql = "INSERT INTO usager (username,password,api_key) 
        VALUES (:username,:password,:api_key);";

        $params = [
            "username" => htmlspecialchars($compte["username"],ENT_QUOTES),
            "password" => password_hash($compte["password"], PASSWORD_DEFAULT),
            "api_key" => $this->guidv4()
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $idUsager = $this->connection->lastInsertId();
        $resultat = $this->afficherUsagerById($idUsager);

        return $resultat ?? [];
    }


    /**
     * Sélectionne l'usager en question.
     * 
     * @param int l'id de l'usager
     * @return DataResponse
     */
    public function afficherUsagerById(int $id): array
    {
        $sql = "SELECT * FROM usager WHERE id = :id ;";

        $params = [
            "id" => $id
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);



        return $result[0] ?? [];
    }


    /**
     * Sélectionne le fakemon de l'id en question
     * 
     * @param int l'id du fakemon
     * @return DataResponse
     */
    public function afficherFakemonById(int $id): array
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
     * @param array les informations du fakemon.
     * @param string l'username du créateur du fakemon.
     * @return DataResponse
     */
    public function insertFakemon(array $fakemon, string $apiKey): array
    {
        $idUsager = $this->chercherUsagerId($apiKey);
        if (empty($idUsager)) {
            $idUsager = [
                "id" => 0
            ];
        }

        $sql = "INSERT INTO creature (nom,id_type1,id_type2,hp,atk,def,sp_atk,sp_def,speed,description,id_usager) 
        VALUES (:nom,:id_type1,:id_type2,:hp,:atk,:def,:sp_atk,:sp_def,:speed,:description,:id_usager);";

        $params = [
            "nom" => htmlspecialchars($fakemon["nom"],ENT_QUOTES) ?? "",
            "id_type1" => $fakemon["id_type1"] ?? 1,
            "id_type2" => $fakemon["id_type2"] ?? 1,
            "hp" => $fakemon["hp"] ?? 0,
            "atk" => $fakemon["atk"] ?? 0,
            "def" => $fakemon["def"] ?? 0,
            "sp_atk" => $fakemon["sp_atk"] ?? 0,
            "sp_def" => $fakemon["sp_def"] ?? 0,
            "speed" => $fakemon["speed"] ?? 0,
            "description" => htmlspecialchars($fakemon["description"],ENT_QUOTES) ?? "",
            "id_usager" => $idUsager["id"]
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $idFakemon = $this->connection->lastInsertId();
        $resultat = $this->afficherFakemonById($idFakemon);

        return $resultat ?? [];
    }

    /**
     * Sélectionne l'id de l'usager avec son username.
     * 
     * @param string la clé d'api.
     * @return DataResponse
     */
    public function chercherUsagerId(string $api_key): array
    {
        try {
            $sql = "SELECT id FROM usager WHERE api_key = :api_key ;";

            $params = [
                "api_key" => $api_key
            ];

            $query = $this->connection->prepare($sql);
            $query->execute($params);

            $result = $query->fetchAll(PDO::FETCH_ASSOC);



            return $result[0] ?? [];
        } catch (\Throwable $th) {
            return []; 
        }
    }


    /**
     * Permet de supprimer un fakemon.
     * 
     * @param int l'id du fakemon
     * @return DataResponse
     */
    public function deleteFakemon(int $id,int $idUsager): array
    {
        $test = $this->afficherFakemonById($id);

        if (empty($test)) {
            $data = [
                "erreur"=> "Id inexistant"
            ];
            $resultat = [
                "data" => $data,
                "status" => 404
            ];
            return $resultat ?? [];
        } else {
            if($test["id_usager"] === $idUsager){
                $sql = "DELETE FROM creature WHERE id=:id ;";

                $params = [
                    "id" => $id
                ];

                $query = $this->connection->prepare($sql);
                $query->execute($params);

                $resultat = [
                    "data" => $test,
                    "status" => 200
                ];

                return $resultat ?? [];
            } 
            else {
                return [];
            }
            
        }
    }


    /**
     * Permet de modifier un fakemon
     * 
     * @param array les informations du fakemon
     * @param string la clé d'api
     * @param int l'id de l'usager
     * @return DataResponse
     */
    public function updateFakemon(array $fakemon, int $idFakemon, string $apikey, int $idUsager): array
    {

        $test = $this->afficherFakemonById($idFakemon);

        if (empty($test)) {
            $resultat = $this->insertFakemon($fakemon, $apikey);
            $resultat = [
                "data" => $resultat,
                "status" => 201
            ];

            return $resultat ?? [];
        } else {
            if ($test["id_usager"] == $idUsager) {
                $sql = "UPDATE creature
                SET nom=:nom,id_type1=:id_type1,id_type2=:id_type2,hp=:hp,atk=:atk,def=:def,sp_atk=:sp_atk,sp_def=:sp_def,speed=:speed,description=:description
                WHERE id = :id";

                $params = [
                    "id" => $idFakemon,
                    "nom" => htmlspecialchars($fakemon["nom"],ENT_QUOTES) ?? "",
                    "id_type1" => $fakemon["id_type1"] ?? 1,
                    "id_type2" => $fakemon["id_type2"] ?? 1,
                    "hp" => $fakemon["hp"] ?? 0,
                    "atk" => $fakemon["atk"] ?? 0,
                    "def" => $fakemon["def"] ?? 0,
                    "sp_atk" => $fakemon["sp_atk"] ?? 0,
                    "sp_def" => $fakemon["sp_def"] ?? 0,
                    "speed" => $fakemon["speed"] ?? 0,
                    "description" => htmlspecialchars($fakemon["description"],ENT_QUOTES) ?? ""
                ];

                $query = $this->connection->prepare($sql);
                $query->execute($params);

                $resultat = [
                    "data" => $this->afficherFakemonById($idFakemon),
                    "status" => 200
                ];

                return $resultat ?? [];
            }
            else {
                return [];
            }
            
        }
    }

    /**
     * Sélectionne la liste des fakemons
     * 
     * @return DataResponse
     */
    public function selectFakemon(string $idUsager): array
    {
        $sql = "SELECT * FROM creature WHERE id_usager = :idUsager ;";


        $query = $this->connection->prepare($sql);
        $params = [
            "idUsager" => $idUsager
        ];
        $query->execute($params);

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
