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
abstract class Category
{
    /**
     * Fashion
     * @var int
     */
    const FASHION = 1;

    /**
     * Music
     * @var int
     */
    const MUSIC = 2;

    /**
     * Art
     * @var int
     */
    const ART = 3;

    /**
     * Films
     * @var int
     */
    const FILMS = 4;

    /**
     * Curator
     * @var int
     */
    const CURATOR = 5;

    /**
     * Business
     * @var int
     */
    const BUSINESS = 6;
}
