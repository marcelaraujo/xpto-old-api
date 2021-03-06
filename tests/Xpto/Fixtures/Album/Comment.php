<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures\Album;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Xpto\Entity\Medias\Album\Comment as CommentAlbumModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment extends AbstractFixture implements OrderedFixtureInterface
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
                    "comment" => "hello - {$i}",
                    "album" => $this->getReference("album_{$i}"),
                    "user" => $this->getReference("user_{$i}"),
                    "id" => $i
                ],
            ];

            foreach ($valores as $valor) {
                $obj = new CommentAlbumModel();
                $obj->setAddress('127.0.0.1');
                $obj->setContent($valor['comment']);
                $obj->setAgent('doctrine fixtures:load');
                $obj->setStatus(CommentAlbumModel::ACTIVE);
                $obj->setAlbum($valor['album']);
                $obj->setUser($valor["user"]);

                $manager->persist($obj);
                $manager->flush();

                $this->addReference('album_comment_' . $i . '_' . $valor['id'], $obj);
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
        return 12;
    }
}
