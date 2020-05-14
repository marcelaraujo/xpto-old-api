<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Albums;

use Xpto\Entity\Medias\Album as AlbumModel;
use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Medias\Album as AlbumService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Album service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class AlbumTest extends PHPUnit_Framework_TestCase
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
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Entity\Albums\Album::setStatus()
     * @covers Xpto\Entity\Albums\Album::isDeleted()
     * @covers Xpto\Service\Albums\Album::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function save()
    {
        $albumService = new AlbumService();

        $this->modifyAttribute($albumService, 'em', $this->getDefaultEmMock());

        $albumModel = new AlbumModel();

        $result = $albumService->save($albumModel);

        $this->assertSame($albumModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Entity\Albums\Album::isDeleted()
     * @covers Xpto\Entity\Albums\Album::getType()
     * @covers Xpto\Entity\Albums\Album::setStatus()
     * @covers Xpto\Service\Albums\Album::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $albumModel = new AlbumModel();

        $albumService = new AlbumService();

        $this->modifyAttribute($albumService, 'em', $this->getDefaultEmMock());

        $result = $albumService->delete($albumModel);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::isDeleted()
     * @covers Xpto\Entity\Albums\Album::__construct()
     * @covers Xpto\Entity\Albums\Album::setCover()
     * @covers Xpto\Entity\Albums\Album::setCreated()
     * @covers Xpto\Entity\Albums\Album::setUpdated()
     * @covers Xpto\Entity\Albums\Album::setTitle()
     * @covers Xpto\Entity\Albums\Album::setTitle()
     * @covers Xpto\Entity\Albums\Album::setType()
     * @covers Xpto\Entity\Albums\Album::setUser()
     * @covers Xpto\Entity\Albums\Album::setStatus()
     * @covers Xpto\Entity\Users\User::getName()
     * @covers Xpto\Service\Albums\Album::createDefaultForUser()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function createDefaultForUser()
    {
        $userModel = new UserModel();

        $albumService = new AlbumService();

        $this->modifyAttribute($albumService, 'em', $this->getDefaultEmMock());

        $result = $albumService->createDefaultForUser($userModel);

        $this->assertEquals(3, count($result));
    }
}
