<?php

declare(strict_types=1);

namespace App\Entity;

class Movie implements \JsonSerializable
{
    private ?int $id;
    private int $extId;
    private string $name;
    private array $tvMazeData;
    private \DateTimeImmutable $lastQueryAt;

    public function __construct(
        int $id = null,
        int $extId,
        string $title,
        array $tvMazeData,
        ?\DateTimeImmutable $date = null
    ) {
        $this->id = $id;
        $this->extId = $extId;
        $this->name = $title;
        $this->tvMazeData = $tvMazeData;
        $this->lastQueryAt = $date ?? new \DateTimeImmutable();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'extId' => $this->extId,
            'title' => $this->name,
            'tvMazeData' => $this->tvMazeData,
            'lastQueryAt' => $this->lastQueryAt->format(\DateTimeInterface::ISO8601)
        ];
    }

    public static function fromStdClass(\stdClass $movie): Movie
    {
        return new Movie(
            $movie->id,
            $movie->extId,
            $movie->name,
            json_decode($movie->tvMazeData, true, 512, JSON_THROW_ON_ERROR),
            new \DateTimeImmutable($movie->lastQueryAt)
        );
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtId(): int
    {
        return $this->extId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTvMazeData(): array
    {
        return $this->tvMazeData;
    }

    public function setTvMazeData(array $tvMazeData): void
    {
        $this->tvMazeData = $tvMazeData;
    }

    public function getLastQueryAt(): \DateTimeImmutable
    {
        return $this->lastQueryAt;
    }

    public function setLastQueryAt(\DateTimeImmutable $lastQueryAt): void
    {
        $this->lastQueryAt = $lastQueryAt;
    }
}
