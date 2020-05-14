<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Value\Category;
use Xpto\Entity\Users\Profile as ProfileModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Profile extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        while ($i <= 10) {
            $profile = [
                'user' => $this->getReference('user_' . $i),
                'customization' => $this->getReference('customization_' . $i),
                'picture' => $this->getReference('media_' . $i . '_' . 1),
                'gender' => 1,
                'birth' => new DateTime(),
                'work_type' => 1,
                'work_area' => 1,
                'bio' => 'lalalalla',
                'full' => 'lalalalal',
                'nick' => 'test' . $i,
                'category' => Category::ART,
                'site' => 'lalalal.org',
                'location_born' => 'Florianópolis - SC',
                'location_live' => 'Florianópolis - SC',
            ];

            $obj = new ProfileModel();
            $obj->setStatus(ProfileModel::NEWER);
            $obj->setBioRelease($profile['bio']);
            $obj->setFullRelease($profile['full']);
            $obj->setBirth($profile['birth']);
            $obj->setGender($profile['gender']);
            $obj->setWorkType($profile['work_type']);
            $obj->setWorkArea($profile['work_area']);
            $obj->setNickname($profile['nick']);
            $obj->setSite($profile['site']);
            $obj->setCategory($profile['category']);
            $obj->setUser($profile['user']);
            $obj->setLocationBorn($profile['location_born']);
            $obj->setLocationLive($profile['location_live']);
            $obj->setCustomization($profile['customization']);
            $obj->setPicture($profile['picture']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('profile_' . $i, $obj);

            $i++;
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}
