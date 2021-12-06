<?php

declare(strict_types=1);

namespace App\Entity;

use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    public function testFromStdClass(): void
    {
        $input = (object)[
            'id' => 1,
            'extId' => 1337,
            'name' => 'testName',
            'tvMazeData' => '{"field": "value"}',
            'lastQueryAt' => '2020-10-11 11:48:30'
        ];

        $expected = new Movie(
            1,
            1337,
            'testName',
            json_decode('{"field": "value"}', true, 512, JSON_THROW_ON_ERROR),
            new \DateTimeImmutable('2020-10-11 11:48:30')
        );

        $this->assertEquals($expected, Movie::fromStdClass($input));
    }
}
