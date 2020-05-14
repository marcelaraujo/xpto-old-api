<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Medias\Album;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Medias\Album\Like as LikeInterface;
use Domain\Entity\Users\User as UserInterface;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 * Like entity
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="album_like",
 *      indexes={
 *          @ORM\Index(name="like_index_id",    columns={"id"}),
 *          @ORM\Index(name="like_index_album", columns={"album_id"}),
 *          @ORM\Index(name="like_index_user",  columns={"user_id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Like extends Persistable implements LikeInterface
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Medias\Album")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     *
     * @var AlbumInterface
     */
    protected $album;

    /**
     * @ORM\Column(name="address", type="string", length=1024, nullable=false)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(name="agent", type="string", length=1024, nullable=false)
     * @var string
     */
    protected $agent;

    /**
     * return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('The user is already deleted', 500);
        }

        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        try {
            v::notEmpty()->ip()->assert($address);

            $this->address = $address;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Address %s is invalid', $address), 500, $e);
        }
    }

    /**
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param string
     */
    public function setAgent($agent)
    {
        try {
            v::notEmpty()->assert($agent);

            $this->agent = $agent;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('User agent %s is not valid', $agent), 500, $e);
        }
    }

    /**
     * @return AlbumInterface
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param AlbumInterface $album
     */
    public function setAlbum(AlbumInterface $album)
    {
        if ($album->isDeleted()) {
            throw new InvalidArgumentException(sprintf('Album %s is deleted', $album->getId()), 500);
        }

        $this->album = $album;
    }
}
