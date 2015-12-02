<?php

namespace VoucherBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use VoucherBundle\Entity\Voucher;

class DefaultControllerTest extends WebTestCase
{
    /** @var  Client */
    private $client;

    /** @var  EntityManager */
    private $em;

    /** @var  Voucher */
    private $voucher;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }


    public function testShowIndex()
    {
        $this->client->request('GET', '/code');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    public function testSendEmptyCode()
    {
        $this->client->request('POST', '/code', array('voucher' => ''));
        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());
    }

    public function testSendFakeCode()
    {
        $this->client->request('POST', '/code', array('voucher' => 'fake_code'));
        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());
    }

    public function testSendValidCode()
    {
        $this->createVoucher();
        $this->client->request('POST', '/code', array('voucher' => $this->voucher->getCode()));
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->removeVoucher();
    }

    private function createVoucher()
    {
        $this->voucher = new Voucher();
        $this->voucher->setCode(date('ymdhis'));
        $this->em->persist($this->voucher);
        $this->em->flush();
    }

    private function removeVoucher()
    {
        $this->em->remove($this->voucher);
        $this->em->flush();
    }

}
