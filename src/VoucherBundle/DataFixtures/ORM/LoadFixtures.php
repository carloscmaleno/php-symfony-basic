<?php
/**
 * File: LoadFixtures.php
 *
 * PHP version 5
 *
 * @category File
 * @package  php-symfony-basic
 * @author   Carlos Coronado <carloscmaleno@gmail.com>
 * @date     20/02/16 19:52
 * @license  http://www.carloscoronado.me  PHP License
 * @link     http://www.carloscoronado.me
 */

namespace VoucherBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use VoucherBundle\Entity\Voucher;

/**
 * Class LoadFixtures
 * @category Class
 * @package  php-symfony-basic
 * @author   Carlos Coronado <carloscmaleno@gmail.com>
 * @license  http://www.carloscoronado.me  PHP License
 * @link     http://www.carloscoronado.me
 */
class LoadFixtures implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function loadUsers(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $voucher = new Voucher();
            $voucher->setCode('TEST' . $i);
            $voucher->setDateAdd(new \DateTime('now'));
            $manager->persist($voucher);
            $manager->flush();
        }
    }
}
