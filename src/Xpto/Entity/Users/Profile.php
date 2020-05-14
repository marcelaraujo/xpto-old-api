<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Users;

use Datetime;
use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Medias\Media;
use Domain\Entity\Users\Customization as CustomizationModel;
use Domain\Entity\Users\Profile as ProfileInterface;
use Domain\Entity\Users\User as UserModel;
use Domain\Value\Category;
use Domain\Value\Gender;
use Domain\Value\MediaType;
use Domain\Value\Work\Area as WorkArea;
use Domain\Value\Work\Type as WorkType;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use OutOfBoundsException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="profile",
 *      indexes={
 *          @ORM\Index(name="profile_index_id", columns={"id"}),
 *          @ORM\Index(name="profile_index_user", columns={"user_id"}),
 *          @ORM\Index(name="profile_index_media", columns={"media_id"}),
 *          @ORM\Index(name="profile_index_customization", columns={"customization_id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Profile extends Persistable implements ProfileInterface
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
     * @ORM\Column(name="birth", type="datetime", nullable=true, options={"default" = null})
     *
     * @var DateTime
     */
    protected $birth;

    /**
     * @ORM\Column(name="gender", type="integer", length=1, nullable=false)
     *
     * @var int
     */
    protected $gender;

    /**
     * @ORM\Column(name="location_born", type="string", length=1024, nullable=true)
     *
     * @var string
     */
    protected $locationBorn;

    /**
     * @ORM\Column(name="location_live", type="string", length=1024, nullable=true)
     *
     * @var string
     */
    protected $locationLive;

    /**
     * @ORM\Column(name="nickname", type="string", length=60, nullable=false, unique=true)
     *
     * @var string
     */
    protected $nickname;

    /**
     * @ORM\Column(name="bio_release", type="string", length=1024, nullable=true)
     *
     * @var string
     */
    protected $bioRelease;

    /**
     * @ORM\Column(name="full_release", type="string", length=1024, nullable=true)
     *
     * @var string
     */
    protected $fullRelease;

    /**
     * @ORM\Column(name="site", type="string", length=1024, nullable=true)
     *
     * @var string
     */
    protected $site;

    /**
     * @ORM\Column(name="work_type", type="integer", length=1, nullable=false)
     *
     * @var int
     */
    protected $workType;

    /**
     * @ORM\Column(name="work_area", type="integer", length=1, nullable=false)
     *
     * @var int
     */
    protected $workArea;

    /**
     * @ORM\Column(name="category", type="integer", length=1, nullable=false)
     *
     * @var int
     */
    protected $category;

    /**
     * @ORM\OneToOne(targetEntity="\Xpto\Entity\Users\User", inversedBy="profile", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var UserModel
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="\Xpto\Entity\Users\Customization", cascade={"persist"})
     * @ORM\JoinColumn(name="customization_id", referencedColumnName="id")
     *
     * @var CustomizationModel
     */
    protected $customization;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Medias\Media", cascade={"persist"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *
     * @var MediaModel
     */
    protected $picture;

    /**
     * @see \Domain\Entity\Profile::getGender()
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @see \Domain\Entity\Profile::setGender()
     */
    public function setGender($gender)
    {
        $genders = [Gender::MALE, Gender::FEMALE];

        try {
            v::notEmpty()->in($genders)->assert($gender);

            $this->gender = $gender;
        } catch (AllOfException $e) {
            throw new OutOfBoundsException(sprintf('Unknown gender %s', $gender), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getBirth()
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * @see \Domain\Entity\Profile::setBirth()
     */
    public function setBirth(DateTime $birth, DateTime $today = null)
    {
        $today = $today ?: new DateTime();

        $tomorrow = clone $today;
        $tomorrow->modify('+1 day');

        if ($birth >= $tomorrow) {
            throw new InvalidArgumentException('Birth date cannot be in the future', 500);
        }

        $this->birth = $birth;
    }

    /**
     * @see \Domain\Entity\Profile::getLocationBorn()
     */
    public function getLocationBorn()
    {
        return $this->locationBorn;
    }

    /**
     * @see \Domain\Entity\Profile::setLocationBorn()
     */
    public function setLocationBorn($location)
    {
        try {
            v::notEmpty()->length(3, 160)->assert($location);

            $this->locationBorn = $location;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Locations born %s is invalid', $location), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getLocationLive()
     */
    public function getLocationLive()
    {
        return $this->locationLive;
    }

    /**
     * @see \Domain\Entity\Profile::setLocationLive()
     */
    public function setLocationLive($location)
    {
        try {
            v::notEmpty()->length(3, 160)->assert($location);

            $this->locationLive = $location;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Locations live %s is invalid', $location), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getNickname()
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @see \Domain\Entity\Profile::setNickname()
     */
    public function setNickname($nickname)
    {
        try {
            v::notEmpty()->alnum()->assert($nickname);

            $this->nickname = $nickname;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Nickname %s is invalid', $nickname), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getBioRelease()
     */
    public function getBioRelease()
    {
        return $this->bioRelease;
    }

    /**
     * @see \Domain\Entity\Profile::setBioRelease()
     */
    public function setBioRelease($release)
    {
        try {
            v::notEmpty()->assert($release);

            $this->bioRelease = $release;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Bio release %s is invalid', $release), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getFullRelease()
     */
    public function getFullRelease()
    {
        return $this->fullRelease;
    }

    /**
     * @see \Domain\Entity\Profile::setFullRelease()
     */
    public function setFullRelease($release)
    {
        try {
            v::notEmpty()->assert($release);

            $this->fullRelease = $release;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Full release %s is invalid', $release), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getSite()
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @see \Domain\Entity\Profile::setSite()
     */
    public function setSite($site)
    {
        try {
            v::notEmpty()->domain()->assert($site);

            $this->site = $site;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Site %s is invalid', $site), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getWorkType()
     */
    public function getWorkType()
    {
        return $this->workType;
    }

    /**
     * @see \Domain\Entity\Profile::setWorkType()
     */
    public function setWorkType($work)
    {
        $works = [
            WorkType::AGENCY,
            WorkType::BUSINESS,
            WorkType::INSTITUTION,
            WorkType::PRODUCER
        ];

        try {
            v::notEmpty()->in($works)->assert($work);

            $this->workType = $work;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Work type %s is invalid', $work), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getWorkArea()
     */
    public function getWorkArea()
    {
        return $this->workArea;
    }

    /**
     * @see \Domain\Entity\Profile::setWorkArea()
     */
    public function setWorkArea($work)
    {
        $works = [
            WorkArea::FILMMAKER,
            WorkArea::MODEL,
            WorkArea::MUSICIAN,
            WorkArea::PHOTOGRAPHER,
            WorkArea::PRODUCER
        ];

        try {
            v::notEmpty()->in($works)->assert($work);

            $this->workArea = $work;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Work area %s is invalid', $work), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getCategory()
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @see \Domain\Entity\Profile::setCategory()
     */
    public function setCategory($category)
    {
        $categories = [
            Category::ART,
            Category::BUSINESS,
            Category::CURATOR,
            Category::FASHION,
            Category::FILMS,
            Category::MUSIC,
        ];

        try {
            v::notEmpty()->in($categories)->assert($category);

            $this->category = $category;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Category %s is invalid', $category), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Profile::getCustomization()
     */
    public function getCustomization()
    {
        return $this->customization;
    }

    /**
     * @see \Domain\Entity\Profile::setCustomization()
     */
    public function setCustomization(CustomizationModel $customization)
    {
        if ($customization->isDeleted()) {
            throw new InvalidArgumentException('This customization is deleted', 500);
        }

        $this->customization = $customization;
    }

    /* (non-PHPdoc)
     * @see \Domain\Entity\Profile::getUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /* (non-PHPdoc)
     * @see \Domain\Entity\Profile::setUser()
     */
    public function setUser(UserModel $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('User is deleted', 500);
        }

        $this->user = $user;
    }

    /**
     * @return \Domain\Entity\Medias\Media
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param Media $media
     *
     * @return void
     */
    public function setPicture(Media $media)
    {
        if ($media->getType() !== MediaType::IMAGE) {
            throw new InvalidArgumentException('Only picture media type is accepted', 500);
        }

        if ($media->isDeleted()) {
            throw new InvalidArgumentException('Media is deleted', 500);
        }

        $this->picture = $media;
    }
}
