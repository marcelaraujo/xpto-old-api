<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Jobs;

use Xpto\Entity\Queue\Mail as MailModel;
use Xpto\Repository\Queue\Mail as MailRepository;
use Knp\Command\Command;
use Swift_Message as Message;
use Swift_TransportException as TransportException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Mail jobs send e-mails from queue
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Mail extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('list')->setDescription('Retrieve mails in queue');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getApplication()->getSilexApplication();

        $repository = new MailRepository($app['orm.em']);

        $list = $repository->findByStatus(MailModel::NEWER);

        $counter = 0;

        foreach ($list as $mail) {
            try {
                $message = Message::newInstance()
                    ->setSubject($mail->getTitle())
                    ->setFrom(array('naoresponda@xpto'))
                    ->setTo($mail->getDestination())
                    ->setBody($mail->getContent());

                $app['mailer']->send($message);

                $app['monolog.default']->addDebug('Sent to ' . $mail->getDestination());

                $mail->setStatus(MailModel::SENDING);

                $app['orm.em']->persist($mail);

                $counter++;
            } catch (TransportException $te) {
                $app['monolog.default']->addDebug($te->getMessage());
            }
        }

        $app['orm.em']->flush();

        $app['monolog.default']->addDebug(sprintf('%d mails sent', $counter));
    }
}
