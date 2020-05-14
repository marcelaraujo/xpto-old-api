<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias\Media;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment Controller Test Case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class CommentTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getMediaWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/media/1/comment');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getMediaWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/media/1/comment', [], [], $this->header);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postMediaWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/media/1/comment');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postMediaWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/media/2/comment', ['comment' => 'Hello world'], [], $this->header);

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putMediaWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('PUT', '/media/1/comment');

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putMediaWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('PUT', '/media/1/comment', [], [], $this->header);

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteMediaWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/media/1/comment/1');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteMediaWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/media/1/comment/1', [], [], $this->header);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
