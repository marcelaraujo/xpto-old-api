<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias\Media;

use Domain\Value\Media\Image as ImageType;
use Domain\Value\MediaType;
use Xpto\Service\Medias\Media\Storage\Cloudinary as StorageServiceInterface;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media as MediaFactory;
use Xpto\Factory\Medias\Media\Detail as DetailFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Image Media Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Image
{
    /**
     * @param UserModel $user
     * @param Request $req
     * @param UploadedFile $file
     * @param StorageServiceInterface $service
     * @return MediaModel
     */
    public static function create(UserModel $user, Request $req, UploadedFile $file, StorageServiceInterface $service)
    {
        $detailsCollection = new ArrayCollection();

        $options = [
            "eager" => [
                [
                    // EXTRA EXTRA SMALL Image size
                    "quality" => 75,
                    "width" => 60,
                    "crop" => "thumb"
                ],
                [
                    // EXTRA SMALL Image size
                    "quality" => 85,
                    "width" => 120,
                    "crop" => "thumb"
                ],
                [
                    // SMALL Image size
                    "quality" => 95,
                    "width" => 210,
                    "crop" => "thumb"
                ],
                [
                    // MEDIUM Image size
                    "quality" => 100,
                    "width" => 300,
                    "crop" => "thumb"
                ]
            ]
        ];

        $detail = $service->upload($file, $options);

        /**
         * Etag
         */
        $etag = $detail['etag'];

        /**
         * Public id
         */
        $publicId = $detail['public_id'];

        /**
         * Original Image
         */
        $detailsCollection->add(
            DetailFactory::create([
                "url" => $detail['url'],
                "width" => $detail['width'],
                "height" => $detail['height'],
                "size" => ImageType::SIZE_LARGE
            ])
        );

        /**
         * XS Image
         */
        $detailsCollection->add(
            DetailFactory::create([
                "url" => $detail['eager'][1]['url'],
                "width" => $detail['eager'][1]['width'],
                "height" => $detail['eager'][1]['height'],
                "size" => ImageType::SIZE_EXTRA_SMALL
            ])
        );

        /**
         * XXS Image
         */
        $detailsCollection->add(
            DetailFactory::create([
                "url" => $detail['eager'][0]['url'],
                "width" => $detail['eager'][0]['width'],
                "height" => $detail['eager'][0]['height'],
                "size" => ImageType::SIZE_EXTRA_EXTRA_SMALL
            ])
        );

        $media = MediaFactory::create($user, $detailsCollection, MediaType::IMAGE, $publicId, $etag);

        return $media;
    }
}
