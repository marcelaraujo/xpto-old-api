<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures;

use Common\Password;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Value\UserType;
use Xpto\Entity\Users\User as UserModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class User extends AbstractFixture implements OrderedFixtureInterface
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
            $user = [
                'id' => $i,
                'status' => UserModel::ACTIVE,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@users.net',
                'password' => 'xxxxx',
                'type' => ($i !== 10 ? UserType::CREATIVE : UserType::CURATOR),
            ];

            $obj = new UserModel();
            $obj->setName($user['name']);
            $obj->setEmail($user['email']);
            $obj->setPassword(Password::generate($user['password']));
            $obj->setStatus($user['status']);
            $obj->setType($user['type']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('user_' . $user['id'], $obj);

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
        return 1;
    }
}
