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
class Youtube
{
    /**
     *
     * @param Request $req
     * @param \Madcoda\Youtube $service
     * @return MediaModel
     */
    public static function create(UserModel $user, Request $req, $service = null)
    {
        $detailsCollection = new ArrayCollection();

        /* @var $service \Madcoda\Youtube */
        if (null !== $service) {
            $videoId = $service->parseVIdFromURL($req->get('url'));

            $video = $service->getVideoInfo($videoId);

            /**
             * Etag
             */
            $etag = str_replace('"', '', $video->etag);

            /**
             * Public id
             */
            $publicId = $videoId;

            /**
             * Medias
             */
            foreach ((array)$video->snippet->thumbnails as $name => $picture) {
                $detailsCollection->add(
                    DetailFactory::create([
                        "url" => $picture->url,
                        "width" => $picture->width,
                        "height" => $picture->height,
                        "size" => $name
                    ])
                );
            }
        }

        $media = MediaFactory::create($user, $detailsCollection, MediaType::YOUTUBE, $publicId, $etag);

        return $media;
    }
}
