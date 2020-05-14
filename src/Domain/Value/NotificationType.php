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
abstract class NotificationType
{
    /**
     * Info notification - default
     * @var int
     */
    const INFO = 1;

    /**
     * Alert notification
     * @var int
     */
    const ALERT = 2;

    /**
     * Error notification
     * @var int
     */
    const ERROR = 3;
}
