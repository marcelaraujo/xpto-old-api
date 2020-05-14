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
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Avatar Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Avatar extends ServiceProviderInterface
{

}
