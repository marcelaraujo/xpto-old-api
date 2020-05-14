<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Queue;

use Domain\Service\Queue\Mail as MailServiceInterface;
use Domain\Entity\Queue\Mail as MailModelInterface;
use Silex\Application;

/**
 * Mail Queue Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Mail implements MailServiceInterface
{
    /**
     * @const string
     */
    const QUEUE_MAIL_INSERT = 'queue.mail.insert';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $service = $this;

        $this->em = $app['orm.em'];

        $app[self::QUEUE_MAIL_INSERT] = $app->protect(
            function(MailModelInterface $mail) use ($app, $service) {
                return $service->save($mail);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param MailModelInterface $mail
     * @return mixed
     */
    public function save(MailModelInterface $mail)
    {
        $this->em->persist($mail);
        $this->em->flush();

        return $mail;
    }
}
