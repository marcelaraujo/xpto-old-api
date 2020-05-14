<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias\Media;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ImageTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        $file = realpath(
            __DIR__ . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'Resources' . DIRECTORY_SEPARATOR .
            'image_normal.jpg'
        );

        $upload = new UploadedFile(
            $file,
            'image_normal.jpg',
            'image/jpeg',
            filesize($file),
            null,
            true
        );

        return [
            [
                [
                    'file' => $upload
                ]
            ]
        ];
    }

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function invalidWrongMimeTypeObjects()
    {
        $file = realpath(
            __DIR__ . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'Resources' . DIRECTORY_SEPARATOR .
            'image_wrong_type.tiff'
        );

        $upload = new UploadedFile(
            $file,
            'image_wrong_type.tiff',
            'image/tiff',
            filesize($file),
            null,
            true
        );

        return [
            [
                [
                    'file' => $upload
                ]
            ]
        ];
    }

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function invalidWrongFileSizeObjects()
    {
        $file = realpath(
            __DIR__ . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'Resources' . DIRECTORY_SEPARATOR .
            'image_wrong_size.jpg'
        );

        $upload = new UploadedFile(
            $file,
            'image_wrong_size.jpg',
            'image/jpeg',
            filesize($file),
            null,
            true
        );

        return [
            [
                [
                    'file' => $upload
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function postMediaWithoutParameters()
    {
        $this->header['HTTP_Content-Type'] = 'multipart/form-data';

        $client = $this->createClient();
        $client->request('POST', '/media/image/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postMediaWithoutParametersAndWithoutAuthHeader()
    {
        $this->header = [];
        $this->header['HTTP_Content-Type'] = 'multipart/form-data';

        $client = $this->createClient();
        $client->request('POST', '/media/image/', [], [], $this->header);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postMediaWithFullParameters($obj)
    {
        $this->header['HTTP_Content-Type'] = 'multipart/form-data';

        $client = $this->createClient();
        $client->request('POST', '/media/image/', [], $obj, $this->header);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider invalidWrongMimeTypeObjects
     */
    public function postMediaWithFullParametersThrowsExceptionWhenImageExtensionIsNotAllowed($obj)
    {
        $this->header['HTTP_Content-Type'] = 'multipart/form-data';

        $client = $this->createClient();
        $client->request('POST', '/media/image/', [], $obj, $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider invalidWrongFileSizeObjects
     */
    public function postMediaWithFullParametersThrowsExceptionWhenImageSizeIsBigThanMaximumAllowed($obj)
    {
        $this->header['HTTP_Content-type'] = 'multipart/form-data';

        $client = $this->createClient();
        $client->request('POST', '/media/image/', [], $obj, $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
