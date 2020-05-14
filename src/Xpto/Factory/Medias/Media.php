<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias;

use Doctrine\Common\Collections\ArrayCollection;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Users\User as UserModel;
use Njasm\Soundcloud\Request\Request;

/**
 * The Media Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Media
{
    /**
     * @param UserModel $user
     * @param ArrayCollection $detailCollection
     * @param int $type
     * @param string $publicId
     * @param string $etag
     * @return MediaModel
     */
    public static function create(UserModel $user, ArrayCollection $detailCollection, $type, $publicId = null, $etag = null)
    {
        $media = new MediaModel();
        $media->setStatus(MediaModel::ACTIVE);
        $media->setType($type);
        $media->setUser($user);
        $media->setPublicId($publicId);
        $media->setEtag($etag);
        $media->setDetails($detailCollection);

        return $media;
    }

    /**
     * @param MediaModel $media
     * @param UserModel $user
     * @param Request $request
     * @return MediaModel
     */
    public static function update(MediaModel $media, UserModel $user, Request $request)
    {
        $media->setStatus(MediaModel::ACTIVE);

        return $media;
    }
}
