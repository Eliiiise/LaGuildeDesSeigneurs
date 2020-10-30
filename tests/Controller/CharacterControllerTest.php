<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests index
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests Display
     */
    public function testDisplay()
    {
        $client = static::createClient();
        $client->request('GET', '/character/display');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests Create
     */
    public function testCreate()
    {
        $client = static::createClient();
        $client->request('POST', '/character/create');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

}
