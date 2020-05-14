<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures\Media;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Xpto\Entity\Medias\Media\Like as LikeMediaModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like extends AbstractFixture implements OrderedFixtureInterface
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
            $valores = [
                [
                    "media" => $this->getReference("media_{$i}_1"),
                    "user" => $this->getReference("user_{$i}"),
                    "id" => $i
                ],
            ];

            foreach ($valores as $valor) {
                $obj = new LikeMediaModel();
                $obj->setAddress('127.0.0.1');
                $obj->setAgent('doctrine fixtures:load');
                $obj->setStatus(LikeMediaModel::ACTIVE);
                $obj->setMedia($valor['media']);
                $obj->setUser($valor["user"]);

                $manager->persist($obj);
                $manager->flush();

                $this->addReference('media_like_' . $i . '_' . $valor['id'], $obj);
            }

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
        return 11;
    }
}
