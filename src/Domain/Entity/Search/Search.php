<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Search;

use Domain\Entity\Entity as EntityInterface;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Search extends EntityInterface
{
    /**
     * @param unknown $word
     *
     * @return void
     */
    public function setWord($word);

    /**
     * @return unknown
     */
    public function getWord();

    /**
     * @param int $results
     *
     * @return void
     */
    public function setResults($results);

    /**
     * @return int
     */
    public function getResults();
}
