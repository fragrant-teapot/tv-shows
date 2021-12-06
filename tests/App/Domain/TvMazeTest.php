<?php

declare(strict_types=1);

namespace App\Domain;

use App\Entity\Movie;
use App\Infrastructure\CurlRequest;
use PHPUnit\Framework\TestCase;

class TvMazeTest extends TestCase
{
    public function testGetMovie()
    {
        $query = 'TestMovie';

        $okResponse = '{"id":123, "name": "TestMovie"}';
        $tvMaze = new TvMaze($this->mockCurlRequest($okResponse));

        $expected = new Movie(null, 123, 'TestMovie', ['id' => 123, 'name' => 'TestMovie']);
        $actual = $tvMaze->getMovie($query);
        $actual->setLastQueryAt($expected->getLastQueryAt());

        $this->assertEquals($expected, $actual);
    }

    private function mockCurlRequest(string $returnValue): CurlRequest
    {
        $getMock = $this->createMock(CurlRequest::class);
        $getMock->expects($this->any())
            ->method('get')
            ->will($this->returnValue($returnValue));

        return $getMock;
    }
}
