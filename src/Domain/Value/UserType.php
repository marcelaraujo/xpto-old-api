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
abstract class UserType
{
    /**
     * Creative Profile
     * @var int
     */
    const CREATIVE = 1;

    /**
     * Curator Profile
     * @var int
     */
    const CURATOR = 2;

    /**
     * Business profile
     * @var int
     */
    const BUSINESS = 3;

    /**
     * Administrator
     * @var int
     */
    const ADMINISTRATOR = 4;

    /**
     * Support
     * @var int
     */
    const SUPPORT = 5;
}
