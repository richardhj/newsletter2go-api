<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api;

use GuzzleHttp\Client as HttpClient;
use League\OAuth2\Client\Token\AccessToken;
use Newsletter2Go\Api\Tool\ApiCredentials;
use Newsletter2Go\Api\Tool\GetParameters;
use Newsletter2Go\OAuth2\Client\Provider\Newsletter2Go as OAuthProvider;


/**
 * Class Api
 * @package Newsletter2Go\Api
 */
class Api
{

    /**
     * The endpoint base url
     *
     * @var string
     */
    protected static $baseUrl = 'https://api.newsletter2go.com';


    /**
     * The OAuth access token instance
     *
     * @var AccessToken
     */
    protected $accessToken;


    /**
     * The ApiCredentials instance
     *
     * @var ApiCredentials
     */
    protected $apiCredentials;


    /**
     * @param AccessToken $accessToken
     *
     * @return Api
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }


    /**
     * @param ApiCredentials $apiCredentials
     *
     * @return Api
     */
    public function setApiCredentials($apiCredentials)
    {
        $this->apiCredentials = $apiCredentials;

        return $this;
    }


    /**
     * Authorize and set the access token
     */
    protected function authorize()
    {
        if (null === $this->apiCredentials->getAuthKey()) {
            throw new \LogicException('Set the auth key beforehand');
        }

        $provider = new OAuthProvider(
            [
                'authKey' => $this->apiCredentials->getAuthKey(),
            ]
        );

        // Refresh token
        if (strlen($this->apiCredentials->getRefreshToken()) || null !== $this->accessToken) {
            $this->setAccessToken(
                $provider->getAccessToken(
                    'https://nl2go.com/jwt_refresh',
                    [
                        'refresh_token' => $this->apiCredentials->getRefreshToken(
                        ) ?: $this->accessToken->getRefreshToken(),
                    ]
                )
            );

            return;
        }

        // Login and fetch new access token
        $this->setAccessToken(
            $provider->getAccessToken(
                'https://nl2go.com/jwt',
                [
                    'username' => $this->apiCredentials->getUsername(),
                    'password' => $this->apiCredentials->getPassword(),
                ]
            )
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
        if (!is_array($params)) {
            $params = [$params];
        }

        return vsprintf($endpoint, $params);
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

        return $endpoint.((strlen($query)) ? '?'.$query : '');
    }


    /**
     * Get the guzzle http client and set base uri and access token header
     *
     * @return HttpClient
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
