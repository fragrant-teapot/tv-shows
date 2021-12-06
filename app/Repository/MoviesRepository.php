<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Illuminate\Database\DatabaseManager;

class MoviesRepository
{
    private DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function findOneByName(string $name): ?Movie
    {
        $ret = $this->manager->select(
            'SELECT id AS id, ext_id AS extId, name AS name, jdoc AS tvMazeData, last_query_at AS lastQueryAt 
                    FROM movies WHERE name = LOWER(:name);',
            [':name' => $name]
        );

        return empty($ret) ? null : Movie::fromStdClass($ret[0]);
    }

    public function save(Movie $movie): void
    {
        $this->manager->insert(
            'INSERT INTO movies (ext_id, name, jdoc, last_query_at) VALUES (:extId, :name, :jdoc, :lastQueryAt);',
            [
                ':extId' => $movie->getExtId(),
                ':name' => $movie->getName(),
                ':jdoc' => json_encode($movie->getTvMazeData()),
                ':lastQueryAt' => $movie->getLastQueryAt()
            ]
        );
    }

    public function update(Movie $movie): void
    {
        $this->manager->update(
            'UPDATE movies SET jdoc = :jdoc, last_query_at = :lastQueryAt WHERE id = :id;',
            [
                ':jdoc' => json_encode($movie->getTvMazeData()),
                ':lastQueryAt' => $movie->getLastQueryAt(),
                ':id' => $movie->getId()
            ]
        );
    }
}
