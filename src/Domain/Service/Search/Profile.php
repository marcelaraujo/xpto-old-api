<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Search;

use Silex\ServiceProviderInterface;

/**
 * Profile Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Profile extends ServiceProviderInterface
{
    /**
     * @param  string $name
     * @return \Domain\Entity\Users\Profile[]
     */
    public function findByName($name);

    /**
     * @param  string $word
     * @return \Domain\Entity\Users\Profile[]
     */
    public function findByBio($word);

    /**
     * @param  string $location
     * @return \Domain\Entity\Users\Profile[]
     */
    public function findByLocation($location);
}
