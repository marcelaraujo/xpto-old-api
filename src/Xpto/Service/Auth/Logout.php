<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Auth;

use Domain\Service\Auth\Logout as LogoutServiceInterface;
use Domain\Entity\Users\User as UserModel;
use Xpto\Repository\Login\Token as TokenRepository;
use Silex\Application;

/**
 * Logout Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Logout implements LogoutServiceInterface
{
    /**
     * @const string
     */
    const AUTH_LOGOUT = 'auth.logout';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $service = $this;
        $this->em = $app['orm.em'];

        $app[self::AUTH_LOGOUT] = $app->protect(
            function (UserModel $user) use ($service) {
                return $service->logout($user);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * Invalidate all tokens from user
     *
     * @param  UserModel $user
     * @return boolean
     */
    public function logout(UserModel $user)
    {
        $repository = new TokenRepository($this->em);
        $tokens = $repository->findAllByUser($user);

        /* @var @token \Xpto\Entity\Login\Token */
        foreach ($tokens as $token) {
            $token->setStatus($token::DELETED);

            $this->em->persist($token);
            $this->em->flush();
        }

        return true;
    }
}
