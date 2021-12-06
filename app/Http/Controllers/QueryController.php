<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\TvMaze;
use App\Repository\MoviesRepository;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
    public function __invoke(
        Request $request,
        Application $app,
        MoviesRepository $repository,
        TvMaze $tvMaze
    ): array {
        $query = $request->query('q');

        if (empty($query) || !is_string($query)) {
            throw new InvalidArgumentException('Invalid query');
        }

        $movie = $repository->findOneByName($query);

        if ($movie === null) {
            $movie = $tvMaze->getMovie($request->query('q'));
            $repository->save($movie);
        } elseif ($movie->getLastQueryAt()->add(new \DateInterval('P1D')) < new \DateTimeImmutable()) {
            $refresh = $tvMaze->getMovie($request->query('q'));
            $movie->setLastQueryAt($refresh->getLastQueryAt());
            $movie->setTvMazeData($refresh->getTvMazeData());
            $repository->update($movie);
        }

        return $movie === null ? [
            'satus' => 'no show found'
        ] : $movie->getTvMazeData();
    }
}
