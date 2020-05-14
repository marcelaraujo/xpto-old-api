<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Album;

use Domain\Entity\Users\User;
use Domain\Service\Medias\Album\Cover as CoverServiceInterface;
use Domain\Value\AlbumType;
use Xpto\Repository\Medias\Album as AlbumRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cover
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Cover implements CoverServiceInterface
{
    /**
     * @const string
     */
    const ALBUM_COVER = 'album.cover';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::ALBUM_COVER] = $this;
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param User $user
     * @return \Xpto\Entity\Medias\Album
     */
    public function listByUser(User $user)
    {
        $album = (new AlbumRepository($this->em))->findOneByUserAndType($user, AlbumType::COVER);

        return $album;
    }
}
