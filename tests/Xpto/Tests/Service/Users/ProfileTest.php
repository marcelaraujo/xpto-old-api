<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Users;

use Xpto\Entity\Users\Profile as ProfileModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Users\Profile as ProfileService;
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
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Doctrine\ORM\EntityManager::getConnection()
     * @covers Doctrine\DBAL\Connection::beginTransaction()
     * @covers Doctrine\DBAL\Connection::commit()
     * @covers Doctrine\DBAL\Connection::rollBack()
     * @covers Xpto\Password::generate()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Entity::setUpdated()
     * @covers Xpto\Entity\Entity::setCreated()
     * @covers Xpto\Entity\Users\Profile::setStatus()
     * @covers Xpto\Entity\Users\Profile::getUser()
     * @covers Xpto\Entity\Users\Profile::setUser()
     * @covers Xpto\Entity\Users\Profile::getId()
     * @covers Xpto\Service\Users\Profile::save()
     * @covers Xpto\Entity\Users\User::isDeleted()
     * @covers Xpto\Entity\Users\User::getPassword()
     * @covers Xpto\Entity\Users\User::setPassword()
     * @covers Xpto\Entity\Users\User::getName()
     * @covers Xpto\Entity\Users\Customization::isDeleted()
     * @covers Xpto\Service\Users\User::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Entity\Albums\Album::setType()
     * @covers Xpto\Entity\Albums\Album::setUser()
     * @covers Xpto\Entity\Albums\Album::setCover()
     * @covers Xpto\Entity\Albums\Album::setTitle()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Service\Albums\Album::createDefaultForUser()
     */
    public function save()
    {
        $profileService = new ProfileService();

        $this->modifyAttribute($profileService, 'em', $this->getDefaultEmMock());

        $userModel = new UserModel();

        $profileModel = new ProfileModel();
        $profileModel->setUser($userModel);

        $result = $profileService->save($profileModel);

        $this->assertSame($profileModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Doctrine\ORM\EntityManager::getConnection()
     * @covers Doctrine\DBAL\Connection::beginTransaction()
     * @covers Doctrine\DBAL\Connection::commit()
     * @covers Doctrine\DBAL\Connection::rollBack()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Users\Profile::setStatus()
     * @covers Xpto\Entity\Users\Profile::getUser()
     * @covers Xpto\Entity\Users\Profile::getId()
     * @covers Xpto\Service\Users\Profile::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function saveWithoutProfile()
    {
        $profileService = new ProfileService();

        $this->modifyAttribute($profileService, 'em', $this->getDefaultEmMock());

        $profileModel = new ProfileModel();

        $result = $profileService->save($profileModel);

        $this->assertSame($profileModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::isDeleted()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Users\Profile::isDeleted()
     * @covers Xpto\Entity\Users\Profile::setStatus()
     * @covers Xpto\Entity\Users\Profile::getUser()
     * @covers Xpto\Entity\Users\Profile::setUser()
     * @covers Xpto\Entity\Users\User::isDeleted()
     * @covers Xpto\Entity\Users\User::setStatus()
     * @covers Xpto\Service\Users\User::delete()
     * @covers Xpto\Service\Users\Profile::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $userModel = new UserModel();

        $profileModel = new ProfileModel();
        $profileModel->setUser($userModel);

        $profileService = new ProfileService();

        $this->modifyAttribute($profileService, 'em', $this->getDefaultEmMock());

        $result = $profileService->delete($profileModel);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Users\Profile::setStatus()
     * @covers Xpto\Entity\Users\Profile::isDeleted()
     * @covers Xpto\Entity\Users\Profile::getUser()
     * @covers Xpto\Service\Users\Profile::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function deleteWithoutProfile()
    {
        $userModel = new UserModel();

        $profileModel = new ProfileModel();
        $profileModel->setUser($userModel);

        $profileService = new ProfileService();

        $this->modifyAttribute($profileService, 'em', $this->getDefaultEmMock());

        $result = $profileService->delete($profileModel);

        $this->assertTrue($result);
    }
}
