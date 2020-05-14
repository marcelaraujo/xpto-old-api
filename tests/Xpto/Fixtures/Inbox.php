<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Xpto\Entity\Inbox\Inbox as InboxModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Inbox extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $valores = [
            [
                'id' => 1,
                'source' => $this->getReference('user_1'),
                'destination' => $this->getReference('user_2'),
                'body' => 'hello from test one'
            ],
            [
                'id' => 2,
                'source' => $this->getReference('user_1'),
                'destination' => $this->getReference('user_3'),
                'body' => 'hello from test two'
            ],
            [
                'id' => 3,
                'source' => $this->getReference('user_3'),
                'destination' => $this->getReference('user_1'),
                'body' => 'hello from test three'
            ],
            [
                'id' => 4,
                'source' => $this->getReference('user_2'),
                'destination' => $this->getReference('user_1'),
                'body' => 'hello from test four'
            ],
        ];

        foreach ($valores as $valor) {
            $obj = new InboxModel();
            $obj->setStatus(InboxModel::ACTIVE);
            $obj->setStatusSource(InboxModel::NEWER);
            $obj->setStatusDestination(InboxModel::NEWER);
            $obj->setSource($valor['source']);
            $obj->setDestination($valor['destination']);
            $obj->setBody($valor['body']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('inbox_' . $obj->getId(), $obj);
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 8;
    }
}
