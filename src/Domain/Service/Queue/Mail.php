<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Queue;

use Domain\Entity\Queue\Mail as MailInterface;
use Silex\ServiceProviderInterface;

/**
 * Mail Queue Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Mail extends ServiceProviderInterface
{
    /**
     * @param MailInterface $mail
     * @return mixed
     */
    public function save(MailInterface $mail);
}
