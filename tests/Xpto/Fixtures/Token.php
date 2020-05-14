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
use Domain\Value\TokenType;
use Xpto\Entity\Login\Token as TokenModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Token extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        $tokens = [
            '25769c6c-d34d-4bfe-ba98-e0ee856f3e7a',
            '40f652b2-9e08-4b22-bcac-6eacfb10c753',
            '85b85f3e-d47e-441e-8c6b-82bfa7319084',
            '00724f88-df4a-45de-815d-a6d3fd40c980',
            'dcf4b8b7-773b-4cc3-82d5-efc48db59f00',
            '02e9c1a5-09eb-40e4-a4af-def4542c20e7',
            '8cf15b96-ef13-45e6-bdeb-1db468995a0e',
            '1e997b05-c4b0-40ed-901a-9db4157dd26b',
            'f5f85e22-8b75-46a0-9eff-81b761d078b0',
            '894ad86f-6451-475d-8778-39af5b3906d9',
        ];

        while ($i <= 10) {
            $token = [
                'id' => $i,
                'user' => $this->getReference('user_' . $i),
                'type' => TokenType::HASH,
                'status' => TokenModel::ACTIVE,
                'content' => array_shift($tokens),
                'expiration' => (new DateTime())->modify('+7 day'),
                'agent' => 'doctrine fixtures:load',
                'address' => '127.0.0.1'
            ];

            $obj = new TokenModel();
            $obj->setStatus(TokenModel::ACTIVE);
            $obj->setUser($token['user']);
            $obj->setContent($token['content']);
            $obj->setAddress($token['address']);
            $obj->setExpiration($token['expiration']);
            $obj->setAgent($token['agent']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('token_' . $token['id'], $obj);

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
        return 6;
    }
}
