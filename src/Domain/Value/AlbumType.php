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
abstract class AlbumType
{
    /**
     * Common
     * @var int
     */
    const COMMON = 1;

    /**
     * Cover
     * @var int
     */
    const COVER = 2;

    /**
     * Profile
     * @var int
     */
    const PROFILE = 3;
}
