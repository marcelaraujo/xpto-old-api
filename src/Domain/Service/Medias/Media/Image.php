<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias\Media;

use Domain\Entity\Medias\Album as AlbumModel;
use Domain\Entity\Medias\Media as MediaModel;
use Domain\Entity\Users\User as UserModel;
use Xpto\Service\Medias\Media\Storage\Cloudinary as StorageServiceInterface;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Avatar Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Image extends ServiceProviderInterface
{
    /**
     * Create an image to user
     *
     * @param UploadedFile $file
     * @param Request $request
     * @param UserModel $user
     * @param StorageServiceInterface $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(
        UploadedFile $file,
        Request $request,
        UserModel $user,
        StorageServiceInterface $storageService
    );
}
