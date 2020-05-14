<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Jobs;

use DateTime;
use Xpto\Entity\Login\Token as TokenModel;
use Xpto\Repository\Login\Token as TokenRepository;
use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Token extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('list')->setDescription('Delete expirated tokens');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getApplication()->getSilexApplication();

        $repository = new TokenRepository($app['orm.em']);

        $list = $repository->findAll();

        $counter = 0;

        foreach ($list as $token) {
            $today = new DateTime();
            $diff = $token->getExpiration()->diff($today)->d;

            // if expiration date is greather than zero, token is valid.. continue.
            if ($diff > 0) {
                continue;
            }

            $token->setStatus(TokenModel::DELETED);

            $app['orm.em']->persist($token);

            $counter++;

            $app['monolog.default']->addDebug(
                sprintf(
                    'expiracao: %s - hoje: %s - diferença: %s',
                    $token->getExpiration()->format('d/m/Y H:i:s'),
                    $today->format('d/m/Y H:i:s'),
                    $diff
                )
            );
        }

        $app['orm.em']->flush();

        $app['monolog.default']->addDebug(sprintf('%d tokens cleaned', $counter));
    }
}
