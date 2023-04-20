<?php

namespace App\Domain\Film\Repository;

use PDO;

/**
 * Repository.
 */
class FilmRepository
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
     * Sélectionne la liste de tous les films
     * 
     * @return DataResponse
     */
    public function selectAllMovies(): array
    {
        $sql = "SELECT * FROM imdb_top;";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

