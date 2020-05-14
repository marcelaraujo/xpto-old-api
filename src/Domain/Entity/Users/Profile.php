<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Users;

use DateTime;
use Domain\Entity\Entity;
use Domain\Entity\Medias\Media;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Profile extends Entity
{
    /**
     * Reproved profile
     *
     * @var int
     */
    const REPROVED = 4;

    /**
     * @return mixed
     */
    public function getGender();

    /**
     * @param int $gender
     *
     * @return void
     */
    public function setGender($gender);

    /**
     * @return DateTime
     */
    public function getBirth();

    /**
     * @param DateTime $birth
     * @param DateTime $today
     *
     * @return void
     */
    public function setBirth(DateTime $birth, DateTime $today = null);

    /**
     * @return mixed
     */
    public function getLocationBorn();

    /**
     * @param mixed $location
     *
     * @return void
     */
    public function setLocationBorn($location);

    /**
     * @return mixed
     */
    public function getLocationLive();

    /**
     * @param mixed $location
     *
     * @return void
     */
    public function setLocationLive($location);

    /**
     * @return string
     */
    public function getNickname();

    /**
     * @param string $nickname
     *
     * @return void
     */
    public function setNickname($nickname);

    /**
     * @return string
     */
    public function getBioRelease();

    /**
     * @param string $release
     *
     * @return void
     */
    public function setBioRelease($release);

    /**
     * @return string
     */
    public function getFullRelease();

    /**
     * @param string $release
     *
     * @return void
     */
    public function setFullRelease($release);

    /**
     * @return string
     */
    public function getSite();

    /**
     * @param string $site
     *
     * @return void
     */
    public function setSite($site);

    /**
     * @return int
     */
    public function getWorkType();

    /**
     * @param int $work
     *
     * @return void
     */
    public function setWorkType($work);

    /**
     * @return int
     */
    public function getWorkArea();

    /**
     * @param int $work
     *
     * @return void
     */
    public function setWorkArea($work);

    /**
     * @return int
     */
    public function getCategory();

    /**
     * @param int $category
     *
     * @return void
     */
    public function setCategory($category);

    /**
     * @return Customization
     */
    public function getCustomization();

    /**
     * @param Customization $customization
     *
     * @return void
     */
    public function setCustomization(Customization $customization);

    /**
     * @return \Domain\Entity\Medias\Media
     */
    public function getPicture();

    /**
     * @param Media $media
     *
     * @return void
     */
    public function setPicture(Media $media);
}
