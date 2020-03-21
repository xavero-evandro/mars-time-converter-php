<?php

namespace App\Controller\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MarsConverterControllerTest extends WebTestCase
{
    public function testGetMarsTime()
    {
        $client = static::createClient();
        $client->request('GET', '/mars-converter/2020-03-18T19:56:55Z');
        $resultMock = json_encode([
            "MarsSolDate" => "51,976.43194",
            "MartianCoordinatedTime" => "10:21:60"
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($resultMock, $client->getResponse()->getContent());
    }

    public function testWrongGetMarsTime()
    {
        $client = static::createClient();
        $client->request('GET', '/mars-converter/20200-03-18T19:56:55Z');
        $exceptionMessage = '"DateTime::__construct(): Failed to parse time string (20200-03-18T19:56:55Z) at position 11 (T): Double time specification"';
        $this->assertEquals(406, $client->getResponse()->getStatusCode());
        $this->assertEquals($exceptionMessage, $client->getResponse()->getContent());
    }
}
