<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /** @var  Client */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testAdminRedirect(){
        $this->client->request('GET', '/admin');
        $this->assertEquals(301, $this->client->getResponse()->getStatusCode());
    }
}
