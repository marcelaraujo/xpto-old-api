<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Users;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\Entity\Users\Profile as ProfileModel;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Users\Profile as ProfileServiceInterface;
use Xpto\Factory\Users\Profile as ProfileFactory;
use Xpto\Repository\Users\Profile as ProfileRepository;
use Xpto\Repository\Users\User as UserRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profile Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Profile implements ProfileServiceInterface
{
    /**
     * @const string
     */
    const USER_PROFILE = 'user.profile';

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

        $app[self::USER_PROFILE] = $service;
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
     * @param  \Xpto\Entity\Users\Profile $profile
     * @return \Xpto\Entity\Users\Profile
     */
    public function save(ProfileModel $profile)
    {
        $this->em->getConnection()->beginTransaction();

        try {
            $this->em->persist($profile);
            $this->em->flush();

            $this->em->getConnection()->commit();
        } catch (UniqueConstraintViolationException $ex) {
            $this->em->getConnection()->rollBack();

            throw new InvalidArgumentException('This nickname is already registered', 409, $ex);
        }

        return $profile;
    }

    /**
     * @param  ProfileModel $profile
     * @return boolean
     */
    public function delete(ProfileModel $profile)
    {
        if ($profile->isDeleted()) {
            throw new InvalidArgumentException('This profile is already deleted.');
        }

        $profile->setStatus(ProfileModel::DELETED);
        $profile->getUser()->setStatus(ProfileModel::DELETED);

        $this->em->persist($profile);
        $this->em->flush();

        return true;
    }

    /**
     * Find profile by user
     *
     * @param UserModel $user
     * @return ProfileModel
     */
    public function findByUser(UserModel $user)
    {
        $repo = new ProfileRepository($this->em);
        $profile = $repo->findByUser($user);

        return $profile;
    }

    /**
     * Find profile by profile id
     *
     * @param int $id
     * @return ProfileModel
     */
    public function findById($id)
    {
        $repo = new ProfileRepository($this->em);
        $profile = $repo->findById($id);

        return $profile;
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
        $repo = new ProfileRepository($this->em);
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

        return $user;
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

        $this->save(ProfileFactory::update($profile, $request));

        return $profile;
    }

    /**
     * Remove a profile
     *
     * @param UserModel $user
     * @return mixed
     */
    public function remove(UserModel $user)
    {
        /* @var $user \Xpto\Entity\Users\Profile */
        $profile = $this->findByUser($user);

        $this->delete($profile);

        return $profile;
    }
}
