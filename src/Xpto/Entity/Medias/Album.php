<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Medias;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Users\User;
use Domain\Value\AlbumType;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="album",
 *      indexes={
 *            @ORM\Index(name="album_index_id", columns={"id"}),
 *            @ORM\Index(name="album_index_user_id", columns={"user_id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Album extends Persistable implements AlbumInterface
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
     * @ORM\Column(name="title", type="string", length=1024, nullable=false)
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="cover", type="boolean", nullable=false)
     *
     * @var boolean
     */
    protected $cover;

    /**
     * @ORM\Column(name="type", type="integer", nullable=true, options={"default" = 1})
     *
     * @var int
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="\Xpto\Entity\Medias\Media", cascade={"persist"})
     * @ORM\JoinTable(name="album_media",
     *   joinColumns={
     *     @ORM\JoinColumn(name="album_id", referencedColumnName="id", nullable=true)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     *   }
     * )
     *
     * @var ArrayCollection
     */
    private $medias;

    /**
     * Constructor
     *
     * Initialize media collection
     */
    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

    /**
     * Set Title
     *
     * @param string $title
     */
    public function setTitle($title = '')
    {
        try {
            v::notEmpty()->assert($title);

            $this->title = $title;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('The title is invalid', 500, $e);
        }
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the Cover
     *
     * @param boolean $cover
     */
    public function setCover($cover)
    {
        try {
            v::int()->in([0, 1])->assert($cover);

            $this->cover = $cover;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('Cover must be 0 or 1', 500, $e);
        }
    }

    /**
     * Get the Cover
     *
     * @return boolean
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Check if album is cover
     *
     * @return boolean
     */
    public function isCover()
    {
        return (boolean)$this->cover;
    }

    /**
     * Get the User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the User
     *
     * @param  User $user
     * @return void
     */
    public function setUser(User $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('User is deleted', 500);
        }

        $this->user = $user;
    }

    /**
     * Set the type
     *
     * @param  int $type
     * @return void
     */
    public function setType($type)
    {
        try {
            $validType = [
                AlbumType::COMMON,
                AlbumType::COVER,
                AlbumType::PROFILE
            ];

            v::notEmpty()->int()->in($validType)->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is invalid', $type), 500, $e);
        }
    }

    /**
     * Get the type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Medias
     *
     * @param  Media[] $medias
     * @return void
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    /**
     * Add Media
     *
     * @param  Media $media
     * @return void
     */
    public function addMedia(Media $media)
    {
        $this->medias[] = $media;
    }

    /**
     * Remove media
     *
     * @param  Media $media
     * @return void
     */
    public function removeMedia(Media $media)
    {
        $this->medias->removeElement($media);
    }

    /**
     * Get medias
     *
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }
}
