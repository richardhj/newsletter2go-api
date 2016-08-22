<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Tool;


/**
 * Class ApiCredentialsFactory
 * @package Newsletter2Go\Api\Tool
 */
class ApiCredentialsFactory
{

    /**
     * Create an ApiCredentials instance
     * Parameter 1 is always the auth key
     * The following parameters might be the (username and the password) OR the refresh token
     *
     * @return ApiCredentials
     */
    public static function create()
    {
        // Credentials with username and password
        if (3 === func_num_args()) {
            list ($authKey, $username, $password) = func_get_args();

            $instance = new ApiCredentials();
            $instance
                ->setAuthKey($authKey)
                ->setUsername($username)
                ->setPassword($password);

            return $instance;

        } // Credentials with refresh token
        elseif (2 === func_num_args()) {
            list($authKey, $refreshToken) = func_get_args();

            $instance = new ApiCredentials();
            $instance
                ->setAuthKey($authKey)
                ->setRefreshToken($refreshToken);

            return $instance;
        }

        throw new \BadFunctionCallException('Provided parameters malicious');
    }


    /**
     * Create an ApiCredentials instance from auth key, username and password
     *
     * @param string $authKey
     * @param string $username
     * @param string $password
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
     * @param string $authKey
     * @param string $refreshToken
     *
     * @return ApiCredentials
     */
    public static function createFromRefreshToken($authKey, $refreshToken)
    {
        return static::create($authKey, $refreshToken);
    }
}
