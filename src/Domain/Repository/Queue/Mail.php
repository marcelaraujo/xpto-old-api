<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Queue;

use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Mail extends Repository
{
    /**
     * @param int $status
     * @return mixed
     */
    public function findByStatus($status = 0);
}
