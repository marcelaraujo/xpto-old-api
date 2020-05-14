<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Search;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class SearchTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        return [
            [
                [
                    'name' => 'Teste',
                    'bio' => 'Teste',
                    'location' => 'Teste',
                ]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByNameWithAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/name/' . $obj['name'], [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByNameWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/name/' . $obj['name']);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByLocationWithAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/location/' . $obj['location'], [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByLocationWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/location/' . $obj['location']);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByBiographyWithAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/bio/' . $obj['bio'], [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function searchByBiographyWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('GET', '/search/bio/' . $obj['bio']);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}
