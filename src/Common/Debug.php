<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Common;

/**
 *
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
class Debug
{
    /**
     * @param null $data
     * @param bool $exit
     */
    public static function debug($data = null, $exit = false)
    {

        echo "<pre>" . print_r($data, true) . "</pre>";

        if ($exit) {
            exit();
        }
    }

    /**
     * @param mixed $data
     * @param string $file
     * @return bool|void
     */
    public static function log($data = null, $file = null)
    {
        if (!isset($file)) {
            $file = tempnam(sys_get_temp_dir(), 'api_');
        }
        return error_log(print_r($data, true) . "\r\n", 3, $file);
    }
}
