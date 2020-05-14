<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Search;

use Xpto\Service\Search\Profile as ProfileService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Profile service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ProfileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateEmMock
     */
    use CreateEmMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Repository\Users\Profile::__construct()
     * @covers Xpto\Repository\Users\Profile::findByUserName()
     * @covers Xpto\Service\Search\Profile::__construct()
     * @covers Xpto\Service\Search\Profile::findByName()
     */
    public function findByName()
    {
        $service = new ProfileService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->findByName('test');

        $this->assertNotNull($result);
    }

    /**
     * @test
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Search\Profile::__construct()
     * @covers Xpto\Service\Search\Profile::findByBio()
     * @covers Xpto\Repository\Users\Profile::__construct()
     * @covers Xpto\Repository\Users\Profile::findByBio()
     */
    public function findByBio()
    {
        $service = new ProfileService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->findByBio('test');

        $this->assertNotNull($result);
    }

    /**
     * @test
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Search\Profile::__construct()
     * @covers Xpto\Service\Search\Profile::findByLocation()
     * @covers Xpto\Repository\Users\Profile::__construct()
     * @covers Xpto\Repository\Users\Profile::findByLocation()
     */
    public function findByLocation()
    {
        $service = new ProfileService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->findByLocation('sc');

        $this->assertNotNull($result);
    }
}
