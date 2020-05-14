<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Medias\Media;

use Domain\Entity\Medias\Media\Comment as CommentModelInterface;
use Xpto\Service\Medias\Media\Comment as CommentService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Comment media service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class CommentTest extends PHPUnit_Framework_TestCase
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
     * @covers \Xpto\Service\Medias\Media\Comment::save()
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Service\Service::setEm()
     * @covers \Doctrine\ORM\EntityManager::persist()
     * @covers \Doctrine\ORM\EntityManager::flush()
     */
    public function save()
    {
        $commentModel = Mockery::mock(CommentModelInterface::class);
        $commentModel->shouldReceive('isDeleted')->andReturn(false)->byDefault();

        $commentService = new CommentService();

        $this->modifyAttribute($commentService, 'em', $this->getDefaultEmMock());

        $this->assertSame($commentModel, $commentService->save($commentModel));
    }

    /**
     * @test
     * @covers Xpto\Service\Medias\Media\Comment::delete()
     * @covers Xpto\Entity\Medias\Media\Comment::isDeleted()
     * @covers Xpto\Entity\Medias\Media\Comment::setStatus()
     * @covers Xpto\Service\Medias\Media\Comment::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     */
    public function delete()
    {
        $commentModel = Mockery::mock(CommentModelInterface::class);
        $commentModel->shouldReceive('isDeleted')->andReturn(false)->byDefault();
        $commentModel->shouldReceive('setStatus')->andReturn(null)->byDefault();

        $commentService = new CommentService();

        $this->modifyAttribute($commentService, 'em', $this->getDefaultEmMock());

        $result = $commentService->delete($commentModel);

        $this->assertTrue($result);
    }
}
