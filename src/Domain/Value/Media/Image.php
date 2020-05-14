<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Value\Media;

/**
 * Object Value
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Image
{

    /**
     * Maximum upload file size
     */
    const MAX_FILE_SIZE = 1310720;

    /**
     * Image Extra Small
     * @var int
     */
    const SIZE_LARGE = 'lg';

    /**
     * Image Extra Small
     * @var int
     */
    const SIZE_MEDIUM = 'md';

    /**
     * Image Extra Small
     * @var int
     */
    const SIZE_SMALL = 'sm';

    /**
     * Image Extra Small
     * @var int
     */
    const SIZE_EXTRA_SMALL = 'xs';

    /**
     * Image Extra Extra Small
     * @var int
     */
    const SIZE_EXTRA_EXTRA_SMALL = 'xxs';
}
