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
use Xpto\Entity\Connections\Connection as ConnectionModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Connection extends AbstractFixture implements OrderedFixtureInterface
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
                'status' => ConnectionModel::APPROVED
            ],
            [
                'id' => 2,
                'source' => $this->getReference('user_2'),
                'destination' => $this->getReference('user_3'),
                'status' => ConnectionModel::NEWER
            ],
            [
                'id' => 3,
                'source' => $this->getReference('user_3'),
                'destination' => $this->getReference('user_1'),
                'status' => ConnectionModel::REPPROVED
            ],
        ];

        foreach ($valores as $valor) {
            $obj = new ConnectionModel();
            $obj->setStatus($valor['status']);
            $obj->setSource($valor['source']);
            $obj->setDestination($valor['destination']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('connection_' . $obj->getId(), $obj);
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 7;
    }
}
