<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Users;

use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Users\User as UserService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * User service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
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
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Password::generate()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Entity\Users\User::getId()
     * @covers Xpto\Entity\Users\User::getPassword()
     * @covers Xpto\Entity\Users\User::setPassword()
     * @covers Xpto\Entity\Users\User::getName()
     * @covers Xpto\Service\Users\User::save()
     * @covers Xpto\Service\Albums\Album::createDefaultForUser()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Entity\Albums\Album::setType()
     * @covers Xpto\Entity\Albums\Album::setUser()
     * @covers Xpto\Entity\Albums\Album::setCover()
     * @covers Xpto\Entity\Albums\Album::setTitle()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Service\Albums\Album::createDefaultForUser()
     * @covers Xpto\Entity\Entity::isDeleted()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Entity::setUpdated()
     * @covers Xpto\Entity\Entity::setCreated()
     */
    public function save()
    {
        $userService = new UserService();

        $this->modifyAttribute($userService, 'em', $this->getDefaultEmMock());

        $userModel = new UserModel();

        $result = $userService->save($userModel);

        $this->assertSame($userModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Users\User::setStatus()
     * @covers Xpto\Entity\Users\User::isDeleted()
     * @covers Xpto\Service\Users\User::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $userModel = new UserModel();

        $userService = new UserService();

        $this->modifyAttribute($userService, 'em', $this->getDefaultEmMock());

        $result = $userService->delete($userModel);

        $this->assertTrue($result);
    }
}
