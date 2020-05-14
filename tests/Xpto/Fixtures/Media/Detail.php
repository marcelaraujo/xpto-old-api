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
use Domain\Value\Media\Image as ImageType;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Medias\Media\Detail as DetailModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Detail extends AbstractFixture implements OrderedFixtureInterface
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
                    "url" => "//res.cloudinary.com/marcelaraujo/image/upload/v1419043224/ejoh1jhluve5ihgz8lvg.jpg",
                    "width" => rand(1, 300),
                    "height" => rand(1, 300),
                    "size" => ImageType::SIZE_EXTRA_EXTRA_SMALL,
                    "id" => 1
                ],
                [
                    "url" => "//res.cloudinary.com/marcelaraujo/image/upload/v1419043224/ejoh1jhluve5ihgz8lvg.jpg",
                    "width" => rand(1, 300),
                    "height" => rand(1, 300),
                    "size" => ImageType::SIZE_EXTRA_SMALL,
                    "id" => 2
                ],
                [
                    "url" => "//res.cloudinary.com/marcelaraujo/image/upload/v1419043224/ejoh1jhluve5ihgz8lvg.jpg",
                    "width" => rand(1, 300),
                    "height" => rand(1, 300),
                    "size" => ImageType::SIZE_LARGE,
                    "id" => 3
                ]
            ];

            foreach ($valores as $valor) {
                $obj = new DetailModel();
                $obj->setHeight($valor['height']);
                $obj->setWidth($valor['width']);
                $obj->setUrl($valor['url']);
                $obj->setSize($valor['size']);

                $manager->persist($obj);
                $manager->flush();

                $this->addReference('media_detail_' . $i . '_' . $valor['id'], $obj);
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
        return 3;
    }
}
