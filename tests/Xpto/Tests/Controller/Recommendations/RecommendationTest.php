<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Recommendations;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class RecommendationTest extends WebTestCase
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
                    'source' => 1,
                    'destination' => 2,
                    'message' => 'Hello world!',
                ]
            ],
        ];
    }

    /**
     * @test
     */
    public function getAllWithHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/recommendation/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/recommendation/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getRecommendationByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/recommendation/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getRecommendationByIdThrowsExceptionWhenIdIsInvalidAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/recommendation/0');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postRecommendationWithoutParametersAndWithAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/recommendation/' . $obj['destination'], [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postRecommendationWithoutParametersAndWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/recommendation/' . $obj['destination']);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postRecommendationWithFullParametersWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/recommendation/' . $obj['destination'], $obj, [], [], json_encode($obj));

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postRecommendationWithFullParametersAndAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/recommendation/' . $obj['destination'], $obj, [], $this->header, json_encode($obj));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
