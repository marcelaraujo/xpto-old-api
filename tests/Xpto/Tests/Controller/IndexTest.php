<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class IndexTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
