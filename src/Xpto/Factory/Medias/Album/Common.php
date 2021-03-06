<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias\Album;

use Domain\Value\AlbumType;
use Xpto\Entity\Users\User;
use Xpto\Factory\Medias\Album;
use Symfony\Component\HttpFoundation\Request;

/**
 * The Common Album Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Common extends Album
{
    /**
     *
     * @param Request $req
     * @param User $user
     * @return Album
     */
    public static function create(Request $req, User $user)
    {
        $album = parent::create($req, $user);
        $album->setType(AlbumType::COMMON);

        return $album;
    }
}
