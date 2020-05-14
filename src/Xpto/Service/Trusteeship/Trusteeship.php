<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Trusteeship;

use Domain\Entity\Users\User as UserModelInterface;
use Domain\Service\Trusteeship\Trusteeship as TrusteeshipServiceInterface;
use Domain\Service\Users\Profile as ProfileServiceInterface;
use Xpto\Service\Users\Profile as ProfileService;
use Xpto\Factory\Users\Profile as ProfileFactory;
use Xpto\Repository\Users\Profile as ProfileRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trusteeship Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Trusteeship implements TrusteeshipServiceInterface
{
    /**
     * @const string
     */
    const TRUSTEESHIP_TRUSTEESHIP = 'trusteeship.trusteeship';

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
        $this->em = $app['orm.em'];

        $app[self::TRUSTEESHIP_TRUSTEESHIP] = $this;
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
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Repository\Users\UserModel[]
     */
    public function listAll(UserModelInterface $user, ProfileServiceInterface $profileService)
    {
        $profile = $profileService->findByUser($user);

        $repository = new ProfileRepository($this->em);

        $profiles = $repository->findNewerByWorkArea($profile->getWorkArea());

        return $profiles;
    }

    /**
     * @param $profileId
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function approve($profileId, UserModelInterface $user, ProfileServiceInterface $profileService)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $profile = $profileService->findById($profileId);
        $profile->getUser()->setStatus(UserModelInterface::ACTIVE);
        $profile->setStatus(UserModelInterface::ACTIVE);

        $profileService->save($profile);

        return $profile;
    }

    /**
     * @param $profileId
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function decline($profileId, UserModelInterface $user, ProfileServiceInterface $profileService)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $profile = $profileService->findById($profileId);
        $profile->getUser()->setStatus(UserModelInterface::DELETED);
        $profile->setStatus(UserModelInterface::DELETED);

        $profileService->save($profile);

        return $profile;
    }
}
