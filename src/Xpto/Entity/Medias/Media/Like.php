<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Medias\Media;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Medias\Media\Like as LikeInterface;
use Domain\Entity\Users\User as UserInterface;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator;

/**
 * Like entity
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="media_like",
 *      indexes={
 *          @ORM\Index(name="like_index_id",    columns={"id"}),
 *          @ORM\Index(name="like_index_media", columns={"media_id"}),
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
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Medias\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *
     * @var MediaInterface
     */
    protected $media;

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
     * @return UserInterface
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
            Validator::notEmpty()->ip()->assert($address);

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
            Validator::notEmpty()->assert($agent);

            $this->agent = $agent;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('User agent %s is not valid', $agent), 500, $e);
        }
    }

    /**
     * @return MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param MediaInterface $media
     */
    public function setMedia(MediaInterface $media)
    {
        if ($media->isDeleted()) {
            throw new InvalidArgumentException(sprintf('Media %s is deleted', $media->getId()), 500);
        }

        $this->media = $media;
    }
}
