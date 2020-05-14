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
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
class Password
{
    /**
     * @param string $password
     * @param int $cost
     * @return bool|false|string
     */
    public static function generate($password, $cost = 12)
    {
        return password_hash($password, PASSWORD_BCRYPT, [
            "cost" => $cost,
            "salt" => static::generateSalt()
        ]);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Creates a salt, with printable ascii chars
     *
     * @return string
     */
    public static function generateSalt()
    {
        $salt = '';

        // bcrypt expects a 22 char salt. Less and it's not happy, more will be truncated and wasted
        for ($i = 0; $i < 22; $i++) {
            $salt .= chr(rand(33, 125));
        }

        return $salt;
    }
}
