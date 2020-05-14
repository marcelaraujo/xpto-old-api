<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias;

use Domain\Entity\Medias\Media as MediaModel;
use Silex\ServiceProviderInterface;

/**
 * Media Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Media extends ServiceProviderInterface
{
    /**
     * @param  MediaModel $media
     * @return MediaModel
     */
    public function save(MediaModel $media);

    /**
     * @param  MediaModel $media
     * @return boolean
     */
    public function delete(MediaModel $media);
}
