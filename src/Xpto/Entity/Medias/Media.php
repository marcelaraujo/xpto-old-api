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
use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Medias\Media\Detail;
use Domain\Entity\Users\User;
use Domain\Value\MediaType;
use Xpto\Entity\Entity as Persistable;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;
use InvalidArgumentException;
use JMS\Serializer\Annotation\Exclude;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="media",
 *      indexes={
 *          @ORM\Index(name="media_index_id", columns={"id"}),
 *          @ORM\Index(name="media_index_user", columns={"user_id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Media extends Persistable implements MediaInterface
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
     * @ORM\OneToMany(targetEntity="\Xpto\Entity\Medias\Media\Detail", mappedBy="media", cascade={"persist", "remove"})
     *
     * @var ArrayCollection
     */
    protected $details;

    /**
     * @ORM\Column(name="type", type="integer", length=1024, nullable=false)
     *
     * @var integer
     */
    protected $type;

    /**
     * @ORM\Column(name="public_id", type="string", length=32, nullable=false)
     *
     * @var string
     */
    protected $publicId;

    /**
     * @ORM\Column(name="etag", type="string", length=128, nullable=false)
     *
     * @var string
     */
    protected $etag;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Exclude
     * @var User
     */
    protected $user;

    /**
     * Constructor
     *
     * Initialize media collection
     */
    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * @param string $publicId
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    }

    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param string $etag
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * @see \Domain\Entity\Media::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @see \Domain\Entity\Media::setType()
     */
    public function setType($type)
    {
        $types = [MediaType::IMAGE, MediaType::SOUNDCLOUD, MediaType::VIMEO, MediaType::YOUTUBE];

        try {
            v::notEmpty()->in($types)->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is not allowed', $type), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Medias\Media::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @see \Domain\Entity\Medias\Media::setUser()
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Set details
     *
     * @param  mixed $details
     * @return void
     */
    public function setDetails(ArrayCollection $details)
    {
        try {
            v::notEmpty()->object()->assert($details);

            $this->details = $details;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Details %s type is not allowed', gettype($details)), 500, $e);
        }
    }

    /**
     * Add detail
     *
     * @param  Detail $detail
     * @return void
     */
    public function addDetail(Detail $detail)
    {
        $this->details[] = $detail;
    }

    /**
     * Remove detail
     *
     * @param  Detail $detail
     * @return void
     */
    public function removeDetail(Detail $detail)
    {
        $this->details->removeElement($detail);
    }

    /**
     * Get details
     *
     * @return ArrayCollection
     */
    public function getDetails()
    {
        return $this->details;
    }
}
