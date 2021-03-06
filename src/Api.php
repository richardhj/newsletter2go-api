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

namespace Richardhj\Newsletter2Go\Api;

use GuzzleHttp\Client as HttpClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use LogicException;
use Richardhj\Newsletter2Go\Api\Tool\ApiCredentials;
use Richardhj\Newsletter2Go\Api\Tool\GetParameters;
use Richardhj\Newsletter2Go\OAuth2\Client\Provider\Newsletter2Go as OAuthProvider;


/**
 * Class Api
 *
 * @package Richardhj\Newsletter2Go\Api
 */
final class Api
{

    /**
     * The endpoint base url
     *
     * @var string
     */
    private static $baseUrl = 'https://api.newsletter2go.com';

    /**
     * The OAuth access token instance
     *
     * @var AccessToken
     */
    private $accessToken;

    /**
     * The ApiCredentials instance
     *
     * @var ApiCredentials
     */
    private $apiCredentials;

    /**
     * Api constructor.
     *
     * @param ApiCredentials|null $apiCredentials The API credentials. Nullable just for BC.
     * @param AccessToken|null    $accessToken    The OAuth2 access token.
     */
    public function __construct(ApiCredentials $apiCredentials = null, AccessToken $accessToken = null)
    {
        $this->apiCredentials = $apiCredentials;
        $this->accessToken    = $accessToken;
    }

    /**
     * Set the access token used for api communication
     *
     * @param AccessToken $accessToken
     *
     * @return Api
     *
     * @deprecated Please inject in the constructor.
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Set the api credentials
     *
     * @param ApiCredentials $apiCredentials
     *
     * @return Api
     *
     * @deprecated Please inject in the constructor.
     */
    public function setApiCredentials($apiCredentials)
    {
        $this->apiCredentials = $apiCredentials;

        return $this;
    }

    /**
     * Authorize and set the access token
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     * @throws LogicException In case the api credentials lack of data.
     * @throws IdentityProviderException
     */
    private function authorize()
    {
        if (null === $this->apiCredentials->getAuthKey()) {
            throw new LogicException('Set the auth key beforehand');
        }

        $provider = new OAuthProvider(
            [
                'authKey' => $this->apiCredentials->getAuthKey(),
            ]
        );

        // Refresh token
        if (null !== $this->accessToken || '' !== $this->apiCredentials->getRefreshToken()) {
            $this->accessToken = $provider->getAccessToken(
                'https://nl2go.com/jwt_refresh',
                [
                    'refresh_token' => $this->apiCredentials->getRefreshToken()
                        ?: $this->accessToken->getRefreshToken(),
                ]
            );

            return;
        }

        if (null === $this->apiCredentials->getUsername() || null === $this->apiCredentials->getPassword()) {
            throw new LogicException('Neither refresh token nor credentials are given.');
        }

        // Login and fetch new access token
        $this->accessToken = $provider->getAccessToken(
            'https://nl2go.com/jwt',
            [
                'username' => $this->apiCredentials->getUsername(),
                'password' => $this->apiCredentials->getPassword(),
            ]
        );
    }

    /**
     * Fill an endpoint path with parameters
     *
     * @param string       $endpoint A path with parameters like `/lists/%s/groups/%s/recipients/%s`
     * @param array|string $params   The parameters to set in the path
     *
     * @return string
     */
    public static function fillEndpointWithParams($endpoint, $params)
    {
        return vsprintf($endpoint, (array)$params);
    }

    /**
     * Add get parameters to the endpoint path. If no GetParameters instance provided,
     * a set of predefined get parameters will be loaded
     *
     * @param string        $endpoint      The endpoint path
     * @param GetParameters $getParameters The GetParameters instance
     *
     * @return string
     */
    public static function addGetParametersToEndpoint($endpoint, GetParameters $getParameters = null)
    {
        // Load default get parameters with predefined values
        if (null === $getParameters) {
            $getParameters = new GetParameters();
        }

        $query = http_build_query($getParameters);

        return $endpoint.('' !== $query ? '?'.$query : '');
    }

    /**
     * Get the guzzle http client and set base uri and access token header
     *
     * @return HttpClient
     *
     * @throws \InvalidArgumentException
     * @throws LogicException
     * @throws \RuntimeException If 'expires' is not set on the access token.
     * @throws IdentityProviderException
     */
    public function getHttpClient()
    {
        if (null === $this->accessToken || $this->accessToken->hasExpired()) {
            $this->authorize();
        }

        return new HttpClient(
            [
                'base_uri' => static::$baseUrl,
                'headers'  => [
                    'authorization' => 'Bearer '.$this->accessToken->getToken(),
                ],
            ]
        );
    }
}
