<?php

declare(strict_types=1);

namespace App\Domain;

use App\Entity\Movie;
use App\Infrastructure\CurlRequest;

class TvMaze
{
    private const API_URL = 'https://api.tvmaze.com';

    private CurlRequest $request;

    public function __construct(CurlRequest $request)
    {
        $this->request = $request;
    }

    public function getMovie(string $title): ?Movie
    {
        $url = sprintf(
            '%s/singlesearch/shows?q=%s',
            self::API_URL,
            $this->cleanQuery($title)
        );

        $movie = $this->parseResponse($this->request->get($url));

        if ($movie !== null && strtolower($movie->getName()) !== strtolower($title)) {
            return null;
        }

        return $movie;
    }

    private function cleanQuery(string $query): string
    {
        return strtolower(trim($query));
    }

    private function parseResponse(string $response): ?Movie
    {
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        return new Movie(
            null,
            $response['id'],
            $response['name'],
            $response
        );
    }
}
