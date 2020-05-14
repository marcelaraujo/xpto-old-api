<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Users;

use DateTime;
use Xpto\Entity\Users\Profile as ProfileModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profile Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Profile
{
    /**
     *
     * @param Request $profile
     * @return ProfileModel
     */
    public static function create(Request $profile)
    {
        $obj = new ProfileModel();
        $obj->setStatus(ProfileModel::ACTIVE);
        $obj->setBioRelease($profile->get('biorelease'));
        $obj->setFullRelease($profile->get('fullrelease'));
        $obj->setGender($profile->get('gender'));
        $obj->setSite($profile->get('site'));
        $obj->setBirth(new DateTime($profile->get('birth')));
        $obj->setNickname($profile->get('nickname'));
        $obj->setWorkType($profile->get('work_type'));
        $obj->setWorkArea($profile->get('work_area'));
        $obj->setCategory($profile->get('category'));
        $obj->setCustomization(Customization::create($profile));
        $obj->setUser(User::create($profile));
        $obj->setLocationBorn($profile->get('location_born'));
        $obj->setLocationLive($profile->get('location_live'));

        return $obj;
    }

    /**
     *
     * @param ProfileModel $profile
     * @param Request $params
     * @return ProfileModel
     */
    public static function update(ProfileModel $profile, Request $params)
    {
        $user = $profile->getUser();
        $user->setName($params->get('name'));
        $user->setEmail($params->get('email'));

        $profile->setBioRelease($params->get('biorelease'));
        $profile->setFullRelease($params->get('fullrelease'));
        $profile->setGender($params->get('gender'));
        $profile->setSite($params->get('site'));
        $profile->setBirth(new DateTime($params->get('birth')));
        $profile->setNickname($params->get('nickname'));
        $profile->setWorkType($params->get('work_type'));
        $profile->setWorkArea($params->get('work_area'));
        $profile->setCategory($params->get('category'));
        $profile->setLocationBorn($params->get('location_born'));
        $profile->setLocationLive($params->get('location_live'));

        return $profile;
    }
}
