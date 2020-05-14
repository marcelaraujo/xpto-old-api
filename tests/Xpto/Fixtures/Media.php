<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Value\MediaType;
use Xpto\Entity\Medias\Media as MediaModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Media extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        $imageJson = '{"public_id":"ejoh1jhluve5ihgz8lvg","version":1419043224,"signature":"460ddccac5387f3f217f7bf988'
            . 'fdf8130f74dd7c","width":842,"height":595,"format":"jpg","resource_type":"image","created_at":"2014-12-2'
            . '0T02:40:24Z","bytes":57158,"type":"upload","url":"http:\/\/res.cloudinary.com\/marcelaraujo\/image\/upload'
            . '\/v1419043224\/ejoh1jhluve5ihgz8lvg.jpg","secure_url":"https:\/\/res.cloudinary.com\/marcelaraujo\/image\/up'
            . 'load\/v1419043224\/ejoh1jhluve5ihgz8lvg.jpg","etag":"11b3afdef9fb8e9d08db0a339b991e17"}';


        $soundCloudJson = '{"public_id":175513642,"version":"1","signature":"54943e986285a","url":"https:\/\/i1.sndcdn'
            . '.com\/artworks-000096228602-cpwba3-large.jpg","width":0,"height":0,"format":"wav","resource_type":"imag'
            . 'e","created_at":"2014\/11\/05 19:51:08 +0000","bytes":37864622,"type":"embed","etag":"\"c63e7e859566be9'
            . 'b6287805a043a0aac\""}';

        $youtubeJson = '{"public_id":"moSFlvxnbgk","version":"1","signature":"5494411f2be44","url":"https:\/\/i.ytimg.'
            . 'com\/vi\/moSFlvxnbgk\/default.jpg","width":120,"height":90,"format":"jpg","resource_type":"image","crea'
            . 'ted_at":"2013-12-06T17:00:01.000Z","bytes":0,"type":"embed","etag":"\"F9iA7pnxqNgrkOutjQAa9F2k8HY\/9JVo'
            . 'pWeTmWj2zlAxapo3z5R7Irw\""}';

        $vimeoJson = '{"public_id":"27127177","version":"1","signature":"5494e3549b250","url":"https:\/\/i.vimeocdn.co'
            . 'm\/video\/215752120_640x360.jpg","width":640,"height":360,"format":"jpg","resource_type":"image","creat'
            . 'ed_at":"2011-07-31T22:02:52+00:00","bytes":0,"type":"embed","etag":"adasdsa"}';

        while ($i <= 10) {
            $valores = [
                [
                    'user' => $this->getReference('user_' . $i),
                    'detail' => json_decode($imageJson, true),
                    'url' => 'http://xpto',
                    'type' => MediaType::IMAGE,
                    'id' => 1,
                ],
                [
                    'user' => $this->getReference('user_' . $i),
                    'detail' => json_decode($soundCloudJson, true),
                    'url' => 'https://soundcloud.com/r3hab/calvin-harris-john-newman-blame-r3hab-trap-remix',
                    'type' => MediaType::SOUNDCLOUD,
                    'id' => 2,
                ],
                [
                    'user' => $this->getReference('user_' . $i),
                    'detail' => json_decode($youtubeJson, true),
                    'url' => 'https://www.youtube.com/watch?v=moSFlvxnbgk',
                    'type' => MediaType::YOUTUBE,
                    'id' => 3,
                ],
                [
                    'user' => $this->getReference('user_' . $i),
                    'detail' => json_decode($vimeoJson, true),
                    'url' => 'https://vimeo.com/27127177',
                    'type' => MediaType::VIMEO,
                    'id' => 4,
                ],
            ];

            foreach ($valores as $valor) {
                $obj = new MediaModel();
                $obj->setType($valor['type']);
                $obj->setStatus(MediaModel::ACTIVE);
                $obj->setUser($valor['user']);
                $obj->setEtag($valor['detail']['etag']);
                $obj->setPublicId($valor['detail']['public_id']);
                $obj->setDetails(new ArrayCollection([
                    $this->getReference('media_detail_' . $i . '_1'),
                    $this->getReference('media_detail_' . $i . '_2'),
                    $this->getReference('media_detail_' . $i . '_3')
                ]));

                $manager->persist($obj);
                $manager->flush();

                if ($valor['type'] === MediaType::IMAGE) {
                    $this->addReference('media_' . $i . '_' . MediaType::IMAGE, $obj);
                }
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
        return 4;
    }
}
