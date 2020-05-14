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
use Domain\Value\AlbumType;
use Xpto\Entity\Medias\Album as AlbumModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Album extends AbstractFixture implements OrderedFixtureInterface
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
                    'user' => $this->getReference('user_' . $i),
                    'type' => AlbumType::COMMON,
                    'title' => 'Common album',
                    'cover' => 1,
                    'status' => AlbumModel::ACTIVE,
                ],
                [
                    'user' => $this->getReference('user_' . $i),
                    'type' => AlbumType::COVER,
                    'title' => 'Cover album',
                    'cover' => 0,
                    'status' => AlbumModel::ACTIVE,
                ],
                [
                    'user' => $this->getReference('user_' . $i),
                    'type' => AlbumType::PROFILE,
                    'title' => 'Profile album',
                    'cover' => 0,
                    'status' => AlbumModel::ACTIVE,
                ]
            ];

            foreach ($valores as $valor) {
                $obj = new AlbumModel();
                $obj->setTitle($valor['title']);
                $obj->setType($valor['type']);
                $obj->setStatus($valor['status']);
                $obj->setCover($valor['cover']);
                $obj->setUser($valor['user']);

                if ($valor['type'] === AlbumType::PROFILE) {
                    $obj->addMedia($this->getReference('media_' . $i . '_' . 1));
                }

                $manager->persist($obj);
                $manager->flush();

                $this->addReference('album_' . $obj->getId(), $obj);
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
        return 5;
    }
}
