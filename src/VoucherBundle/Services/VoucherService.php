<?php
/**
 * File: VoucherService.php
 *
 * PHP version 5
 *
 * @category File
 * @package  skinacademy
 * @author   Carlos Coronado <carlos.coronado@laviniainteractivac.com>
 * @date     2/12/15 13:15
 * @license  http://www.laviniainteractiva.com  PHP License
 * @link     http://www.laviniainteractiva.com
 */


namespace VoucherBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use VoucherBundle\Entity\Voucher;

/**
 * Class VoucherService
 * @category Class
 * @package  skinacademy
 * @author   Carlos Coronado <carlos.coronado@laviniainteractivac.com>
 * @date     2/12/15 13:15
 * @license  http://www.laviniainteractiva.com  PHP License
 * @link     http://www.laviniainteractiva.com
 */
class VoucherService
{
    /** @var  EntityManager */
    private $em;

    /** @var  Session */
    private $session;

    /**
     * VoucherService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * Save voucher to session
     * @param Voucher $voucher
     */
    public function saveVoucher(Voucher $voucher)
    {
        $this->session->set('voucher', $voucher->getCode());
    }

    /**
     * Assign voucher to user
     * @param User $user
     * @return bool
     *
     */
    public function assignVoucher(User $user)
    {
        $this->session->get('voucher');
    }
}
