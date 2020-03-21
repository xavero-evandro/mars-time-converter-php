<?php

namespace App\Service\Tests;

use App\Service\MarsConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MarsConverterTest extends TestCase
{
    public function testGetMarsTime()
    {
        $marsConverter = new MarsConverter();
        $result = $marsConverter->getMarsTime(new \DateTime("2020-03-18T19:56:55Z"));
        $resultMock = [
            "MarsSolDate" => "51,976.43194",
            "MartianCoordinatedTime" => "10:21:60"
        ];
        // assert that your calculator added the numbers correctly!
        $this->assertEquals($resultMock, $result);
    }

    /**
     * @expectedException Exception
     */
    public function testWrongGetMarsTimeParameter()
    {
        $marsConverter = new MarsConverter();
        $marsConverter->getMarsTime(new \DateTime("20200-03-18T19:56:55Z"));
    }
}
