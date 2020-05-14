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
use Xpto\Entity\Recommendations\Recommendation as RecommendationModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Recommendation extends AbstractFixture implements OrderedFixtureInterface
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
                'message' => 'hello from test one'
            ],
            [
                'id' => 2,
                'source' => $this->getReference('user_2'),
                'destination' => $this->getReference('user_3'),
                'message' => 'hello from test two'
            ],
            [
                'id' => 3,
                'source' => $this->getReference('user_3'),
                'destination' => $this->getReference('user_1'),
                'message' => 'hello from test three'
            ],
        ];

        foreach ($valores as $valor) {
            $obj = new RecommendationModel();
            $obj->setStatus(RecommendationModel::ACTIVE);
            $obj->setSource($valor['source']);
            $obj->setDestination($valor['destination']);
            $obj->setMessage($valor['message']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('recommendation_' . $obj->getId(), $obj);
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 9;
    }
}
