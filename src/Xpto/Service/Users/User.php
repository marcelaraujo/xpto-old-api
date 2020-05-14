<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Users;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Users\User as UserServiceInterface;
use Common\Password;
use Xpto\Repository\Users\User as UserRepository;
use Xpto\Repository\Users\Profile as ProfileRepository;
use Xpto\Factory\Users\Profile as ProfileFactory;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class User implements UserServiceInterface
{
    /**
     * @const string
     */
    const USER_USER = 'user.user';

    /**
     * @const string
     */
    const USER_CREATE = 'user.create';

    /**
     * @const string
     */
    const USER_DELETE = 'user.delete';

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

        $app[self::USER_USER] = $service;

        $app[self::USER_CREATE] = $app->protect(
            function(UserModel $user) use ($app, $service) {
                return $service->save($user);
            }
        );

        $app[self::USER_DELETE] = $app->protect(
            function(UserModel $user) use ($app, $service) {
                return $service->delete($user);
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
     * @param  UserModel $user
     * @return UserModel
     */
    public function save(UserModel $user)
    {
        if (!$user->getId()) {
            $cleanPassword = $user->getPassword();
            $cryptPassword = Password::generate($cleanPassword);

            $user->setPassword($cryptPassword);
        }

        try {
            $this->em->persist($user);
        } catch (UniqueConstraintViolationException $ex) {
            throw new InvalidArgumentException('This email is already registered', 409, $ex);
        }

        return $user;
    }

    /**
     * @param  UserModel $user
     * @return boolean
     */
    public function delete(UserModel $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('This user is already deleted');
        }

        $user->setStatus(UserModel::DELETED);

        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return ProfileModel
     */
    public function findByUserId($id)
    {
        $repo = new UserRepository($this->em);
        $user = $repo->findById($id);

        return $user;
    }

    /**
     * List all profiles
     *
     * @return array|mixed
     */
    public function listAll()
    {
        $repo = new UserRepository($this->em);
        $users = $repo->findAll();

        return $users;
    }

    /**
     * Find one by nickname
     *
     * @param $nickname
     * @return null|object
     */
    public function findByNickname($nickname)
    {
        $repo = new ProfileRepository($this->em);
        $user = $repo->findByNickname($nickname);

        return $user->getUser();
    }

    /**
     * Update profile
     *
     * @param UserModel $user
     * @param Request $request
     * @return mixed
     */
    public function update(UserModel $user, Request $request)
    {
        /* @var $repository \Xpto\Repository\Users\Profile */
        $repository = new ProfileRepository($this->em);

        /* @var $user \Xpto\Entity\Users\Profile */
        $profile = $repository->findByUser($user);

        /* @var $update \Xpto\Entity\Users\Profile */
        $update = ProfileFactory::update($profile, $request);

        $this->save($update->getUser());

        return $update->getUser();
    }
}
