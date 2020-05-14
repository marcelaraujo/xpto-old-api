<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Medias\Media;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Medias\Media\Detail as DetailInterface;
use Xpto\Entity\Entity as Persistable;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="media_details",
 *      indexes={
 *          @ORM\Index(name="media_details_index_id", columns={"id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Detail extends Persistable implements DetailInterface
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
     * @ORM\Column(name="url", type="string", length=256, nullable=false)
     *
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(name="width", type="integer", nullable=false)
     *
     * @var int
     */
    protected $width;

    /**
     * @ORM\Column(name="height", type="integer", nullable=false)
     *
     * @var int
     */
    protected $height;

    /**
     * @ORM\Column(name="size", type="string", length=32, nullable=false)
     *
     * @var string
     */
    protected $size;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Medias\Media", inversedBy="details")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *
     * @var MediaInterface
     **/
    protected $media;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @throws InvalidArgumentException
     */
    public function setUrl($url)
    {
        try {
            v::notEmpty()->assert($url);

            $this->url = $url;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('URL %s is invalid', $url), 500, $e);
        }
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @throws InvalidArgumentException
     */
    public function setWidth($width = 0)
    {
        try {
            v::int()->assert($width);

            $this->width = $width;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Width %s is invalid', $width), 500, $e);
        }
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @throws InvalidArgumentException
     */
    public function setHeight($height)
    {
        try {
            v::int()->assert($height);

            $this->height = $height;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Height %s is invalid', $height), 500, $e);
        }
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

//    /**
//     * @return MediaInterface
//     */
//    public function getMedia()
//    {
//        return $this->media;
//    }
//
//    /**
//     * @param MediaInterface $media
//     */
//    public function setMedia(MediaInterface $media)
//    {
//        $this->media = $media;
//    }
}
