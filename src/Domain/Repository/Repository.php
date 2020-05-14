<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Repository
{
    /**
     * Find all
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Find One
     *
     * @param integer $id
     *
     * @return Entity
     */
    public function findById($id);
}
