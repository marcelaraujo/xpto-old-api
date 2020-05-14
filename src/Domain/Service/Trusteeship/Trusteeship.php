<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Trusteeship;

use Domain\Entity\Users\User as UserModelInterface;
use Domain\Service\Users\Profile as ProfileServiceInterface;
use Silex\ServiceProviderInterface;

/**
 * Profile Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Trusteeship extends ServiceProviderInterface
{
    /**
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Repository\Users\UserModel[]
     */
    public function listAll(UserModelInterface $user, ProfileServiceInterface $profileService);

    /**
     * @param $profileId
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function approve($profileId, UserModelInterface $user, ProfileServiceInterface $profileService);

    /**
     * @param $profileId
     * @param UserModelInterface $user
     * @param ProfileServiceInterface $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function decline($profileId, UserModelInterface $user, ProfileServiceInterface $profileService);
}
