<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias\Media;

use Domain\Value\MediaType;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media\Detail as DetailFactory;
use Xpto\Factory\Medias\Media as MediaFactory;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Vimeo
{
    /**
     * @param UserModel $user
     * @param Request $req
     * @param \Vimeo\Vimeo $service
     * @return MediaModel
     */
    public static function create(UserModel $user, Request $req, $service = null)
    {
        $detailsCollection = new ArrayCollection();

        /* @var $service \Vimeo\Vimeo */
        if (null !== $service) {
            $url = parse_url($req->get('url'));

            $videoId = substr($url['path'], 1);

            $response = $service->request('/videos/' . $videoId, [], 'GET');

            $video = $response['body'];

            /**
             * Etag
             */
            $etag = sha1(json_encode($video));

            /**
             * Public id
             */
            $publicId = $videoId;

            /**
             * Medias
             */
            foreach ($video['pictures']['sizes'] as $picture) {
                $detailsCollection->add(
                    DetailFactory::create([
                        "url" => $picture['link'],
                        "width" => $picture['width'],
                        "height" => $picture['height'],
                        "size" => "{$picture['width']}_{$picture['height']}"
                    ])
                );
            }
        }

        $media = MediaFactory::create($user, $detailsCollection, MediaType::VIMEO, $publicId, $etag);

        return $media;
    }
}
