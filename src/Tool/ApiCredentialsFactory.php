<?php

/**
 * This file is part of richardhj/newsletter2go-api.
 *
 * Copyright (c) 2016-2017 Richard Henkenjohann
 *
 * @package   richardhj/newsletter2go-api
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2017 Richard Henkenjohann
 * @license   https://github.com/richardhj/newsletter2go-api/blob/master/LICENSE LGPL-3.0
 */

namespace Richardhj\Newsletter2Go\Api\Tool;

use BadFunctionCallException;


/**
 * Class ApiCredentialsFactory
 *
 * @package Richardhj\Newsletter2Go\Api\Tool
 */
class ApiCredentialsFactory
{

    /**
     * Create an ApiCredentials instance
     * Parameter 1 is always the auth key
     * The following parameters might be the (username and the password) OR the refresh token
     *
     * @return ApiCredentials
     *
     * @throws \BadFunctionCallException If neither 2 nor 3 arguments are passed to this method.
     */
    public static function create()
    {
        if (3 === \func_num_args()) {
            // Credentials with username and password
            list ($authKey, $username, $password) = \func_get_args();

            $instance = new ApiCredentials();
            $instance
                ->setAuthKey($authKey)
                ->setUsername($username)
                ->setPassword($password);

            return $instance;

        }

        if (2 === \func_num_args()) {
            // Credentials with refresh token
            list($authKey, $refreshToken) = \func_get_args();

            $instance = new ApiCredentials();
            $instance
                ->setAuthKey($authKey)
                ->setRefreshToken($refreshToken);

            return $instance;
        }

        throw new BadFunctionCallException('Provided parameters malicious');
    }

    /**
     * Create an ApiCredentials instance from auth key, username and password
     *
     * @param string $authKey  The auth key of the Newsletter2Go account.
     * @param string $username The user's personal username.
     * @param string $password The user's personal password.
     *
     * @return ApiCredentials
     */
    public static function createFromUsernameAndPassword($authKey, $username, $password)
    {
        return static::create($authKey, $username, $password);
    }

    /**
     * Create an ApiCredentials instance from auth key and refresh token
     *
     * @param string $authKey      The auth key of the Newsletter2Go account.
     * @param string $refreshToken The valid refresh token.
     *
     * @return ApiCredentials
     */
    public static function createFromRefreshToken($authKey, $refreshToken)
    {
        return static::create($authKey, $refreshToken);
    }
}
