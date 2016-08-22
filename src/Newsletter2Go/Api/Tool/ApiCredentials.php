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
 * Class ApiCredentials
 * @package Newsletter2Go\Api\Tool
 */
class ApiCredentials
{

    /**
     * @var string
     */
    protected $authKey;


    /**
     * @var string
     */
    protected $username;


    /**
     * @var string
     */
    protected $password;


    /**
     * @var string
     */
    protected $refreshToken;


    /**
     * @param string $authKey
     *
     * @return self
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;

        return $this;
    }


    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }


    /**
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }


    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @param string $refreshToken
     *
     * @return ApiCredentials
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }


    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}