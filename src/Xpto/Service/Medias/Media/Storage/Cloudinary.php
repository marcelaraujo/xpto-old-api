<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media\Storage;

use Cloudinary as Driver;
use Cloudinary\Uploader as Uploader;
use Domain\Value\Media\Image as ImageType;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * Cloudinary Service Provider
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Cloudinary implements ServiceProviderInterface
{
    /**
     * @const string
     */
    const MEDIA_STORAGE_CLOUDINARY = 'media.storage.cloudinary';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->config = $app['config']['cloudinary'];

        $app[self::MEDIA_STORAGE_CLOUDINARY] = $this;
    }

    /**
     * @param Application $app
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * Send a file to cloudinary
     *
     * @param UploadedFile $file
     * @param array $options
     * @return mixed
     */
    public function upload(UploadedFile $file, $options = [])
    {
        /**
         * Handle when file upload exceeds PHP `post_max_size` and `max_file_upload`
         */
        if ($file->getError() > 0 && $file->getMaxFilesize() > ImageType::MAX_FILE_SIZE) {
            $message = sprintf(
                'Max file upload size exceeded. Got %d bytes, but limit is %d bytes.',
                $file->getMaxFilesize(),
                ImageType::MAX_FILE_SIZE
            );

            throw new UploadException($message, 500);
        }

        /**
         * Validate the maximum image size
         */
        if ($file->getClientSize() > ImageType::MAX_FILE_SIZE) {
            $message = sprintf(
                'Max file upload size exceeded. Got %d bytes, but limit is %d bytes.',
                $file->getClientSize(),
                ImageType::MAX_FILE_SIZE
            );

            throw new UploadException($message, 500);
        }

        /**
         * Validate image upload extension
         */
        try {
            $validType = [
                "png",
                "jpg",
                "jpeg"
            ];

            v::notEmpty()->string()->in($validType)->assert($file->getClientOriginalExtension());
        } catch (AllOfException $e) {
            $message = sprintf('This file extension %s is not allowed.', $file->getClientOriginalExtension());

            throw new UploadException($message, 500, $e);
        }

        Driver::config(
            [
                "cloud_name" => $this->config['cloud_name'],
                "api_key" => $this->config['api_key'],
                "api_secret" => $this->config['api_secret']
            ]
        );

        return Uploader::upload($file, $options);
    }
}
