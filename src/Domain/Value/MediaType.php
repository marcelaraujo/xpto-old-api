<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Value;

/**
 * Object Value
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class MediaType
{
    /**
     * Image
     * @var int
     */
    const IMAGE = 1;

    /**
     * Youtube
     * @var int
     */
    const YOUTUBE = 2;

    /**
     * Vimeo
     * @var int
     */
    const VIMEO = 3;

    /**
     * Soundcloud
     * @var int
     */
    const SOUNDCLOUD = 4;
}
