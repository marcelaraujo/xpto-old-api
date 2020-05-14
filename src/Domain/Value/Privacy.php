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
abstract class Privacy
{
    /**
     * All network can view
     *
     * @var int
     */
    const EVERYONE = 1;

    /**
     * Only connections can view
     *
     * @var int
     */
    const CONNECTIONS = 2;

    /**
     * Private content
     *
     * @var int
     */
    const PARTICULAR = 3;
}
