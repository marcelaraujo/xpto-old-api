<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias\Media;

use InvalidArgumentException;
use Domain\Value\MediaType;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media as MediaFactory;
use Xpto\Factory\Medias\Media\Detail as DetailFactory;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class SoundCloud
{
    /**
     * @param UserModel $user
     * @param Request $req
     * @param \Njasm\Soundcloud\SoundcloudFacade $service
     * @return MediaModel
     */
    public static function create(UserModel $user, Request $req, $service = null)
    {
        $detailsCollection = new ArrayCollection();

        /* @var $service \Njasm\Soundcloud\SoundcloudFacade */
        if (null !== $service) {
            /* @var $responseSoundcloud \Njasm\Soundcloud\Request\Response */
            $responseSoundcloud = $service->get('/resolve', ['url' => $req->get('url')])->asJson()->request();

            if ((int)$responseSoundcloud->getHttpCode() !== 302) {
                throw new InvalidArgumentException("This url is not valid.");
            }

            /* @var $track \StdClass */
            $track = $responseSoundcloud->bodyObject();

            /* @var $url array */
            $url = parse_url($track->location);

            /* @var $response \Njasm\Soundcloud\Request\Response */
            $response = $service->get($url['path'])->asJson()->request();
            $headers = $response->getHeaders();

            /* @var $sound \stdClass */
            $sound = $response->bodyObject();

            /**
             * Etag
             */
            $etag = str_replace('"', '', $headers['Etag']);

            /**
             * Public id
             */
            $publicId = $sound->id;

            /**
             * Original Media
             */
            $detailsCollection->add(
                DetailFactory::create([
                    "url" => $sound->artwork_url,
                    "width" => 0,
                    "height" => 0,
                    "size" => "original"
                ])
            );
        }

        $media = MediaFactory::create($user, $detailsCollection, MediaType::SOUNDCLOUD, $publicId, $etag);

        return $media;
    }
}
