<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias\Album;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Like Controller Test Case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class LikeTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getAlbumWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/1/like');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAlbumWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/1/like', [], [], $this->header);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAlbumWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/album/1/like');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAlbumWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/album/2/like', [], [], $this->header);

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putAlbumWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('PUT', '/album/1/like');

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putAlbumWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('PUT', '/album/1/like', [], [], $this->header);

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteAlbumWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/album/1/like/1');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteAlbumWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/album/1/like/1', [], [], $this->header);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
