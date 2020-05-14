<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Users;

use Domain\Entity\Users\Profile as ProfileModel;
use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;

/**
 * Profile Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Profile extends ServiceProviderInterface
{
    /**
     * @param  ProfileModel $profile
     * @return ProfileModel
     */
    public function save(ProfileModel $profile);

    /**
     * @param  ProfileModel $profile
     * @return boolean
     */
    public function delete(ProfileModel $profile);

    /**
     * @param UserModel $user
     * @return ProfileModel
     */
    public function findByUser(UserModel $user);
}
