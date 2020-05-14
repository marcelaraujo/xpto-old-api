<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias;

use Domain\Entity\Medias\Album as AlbumModel;
use Domain\Entity\Medias\Media as MediaModel;
use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;

/**
 * Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Album extends ServiceProviderInterface
{
    /**
     * Save an album
     *
     * @param  AlbumModel $album
     * @param  MediaModel $media
     * @return AlbumModel
     */
    public function save(AlbumModel $album, MediaModel $media = null);

    /**
     * Remove album
     *
     * @param  AlbumModel $album
     * @return boolean
     */
    public function delete(AlbumModel $album);

    /**
     * Remove media from an album
     *
     * @param  int $album
     * @param  int $media
     * @return AlbumModel
     */
    public function removeMedia($media, $album, UserModel $user);

    /**
     * Create the default albums for user
     *
     * @param  UserModel $user
     * @return AlbumModel[]
     */
    public function createDefaultForUser(UserModel $user);
}
