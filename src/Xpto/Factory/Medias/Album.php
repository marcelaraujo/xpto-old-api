<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias;

use Xpto\Entity\Medias\Album as AlbumModel;
use Xpto\Entity\Users\User as UserModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * The Album Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Album
{
    /**
     *
     * @param Request $req
     * @param UserModel $user
     * @return AlbumModel
     */
    public static function create(Request $req, UserModel $user)
    {
        $album = new AlbumModel();
        $album->setStatus(AlbumModel::ACTIVE);
        $album->setType($req->get('type'));
        $album->setTitle($req->get('title'));
        $album->setCover($req->get('cover'));
        $album->setUser($user);

        return $album;
    }

    /**
     *
     * @param AlbumModel $album
     * @param Request $req
     * @return boolean
     */
    public static function update(AlbumModel $album, Request $req)
    {
        $album->setTitle($req->get('title'));
        $album->setCover($req->get('cover'));

        return $album;
    }
}
