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


/**
 * Class ApiCredentials
 *
 * @package Richardhj\Newsletter2Go\Api\Tool
 */
class ApiCredentials
{

    /**
     * @var string
     */
    private $authKey;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $refreshToken;

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