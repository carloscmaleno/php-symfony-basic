<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UserBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    /** @var  Client */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider getPublicUrls
     * @param $url
     */
    public function testPublicUrl($url)
    {
        $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider getPrivateUrls
     * @param $url
     */
    public function testPrivateUrl($url)
    {
        $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }


    public function testLoginError()
    {
        $this->client->request('POST', '/login', array('email' => 'fake@email.com', 'password' => 'fakepassword'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('false', $this->client->getResponse()->getContent());
        $this->assertContains('json', $this->client->getResponse()->headers->get('Content-Type'));
    }

    public function testLoginSuccess()
    {
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();

        $user = new User();
        $user->setUsername('phpunit');
        $user->setEmail('php@unit.com');
        $user->setRoles(array('ROLE_USER'));

        $encodedPassword = $encoder->encodePassword($user, 'phpunit');
        $user->setPassword($encodedPassword);

        $em->persist($user);
        $em->flush();

        $this->client->request('POST', '/login', array('email' => 'php@unit.com', 'password' => 'phpunit'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('true', $this->client->getResponse()->getContent());
        $this->assertContains('json', $this->client->getResponse()->headers->get('Content-Type'));

        $em->remove($user);
        $em->flush();
    }

    public function getPublicUrls()
    {
        return array(
            array('/login'),
            array('/contact'),
            array('/legal'),
        );
    }

    public function getPrivateUrls()
    {
        return array(
            array('/'),
            array('/admin'),
        );
    }
}
