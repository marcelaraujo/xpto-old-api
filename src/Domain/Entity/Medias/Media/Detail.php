<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Medias\Media;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
interface Detail
{
    /**
     * @return int
     */
    public function getUrl();

    /**
     * @param int $url
     */
    public function setUrl($url);

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @param int $width
     */
    public function setWidth($width);

    /**
     * @return int
     */
    public function getHeight();

    /**
     * @param int $height
     */
    public function setHeight($height);

    /**
     * @return string
     */
    public function getSize();

    /**
     * @param string $size
     */
    public function setSize($size);
}
