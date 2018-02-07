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

namespace Richardhj\Newsletter2Go\Api\Model;

use Richardhj\Newsletter2Go\Api\Tool\ApiCredentials;
use Richardhj\Newsletter2Go\Api\Tool\GetParameters;


/**
 * Class ModelBasicFindTrait
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
trait ModelBasicFindTrait
{

    /**
     * Find a particular item by its id
     *
     * @param string         $id
     * @param ApiCredentials $credentials
     *
     * @return AbstractModel|null
     *
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public static function findById($id, ApiCredentials $credentials = null)
    {
        /** @var AbstractModel $model */
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->getApi()->fillEndpointWithParams(static::$endpointResource.'/%s', $id);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);


        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if (0 === $json->info->count) {
            return null;
        }

        return $model->setData((array)reset($json->value));
    }

    /**
     * Find all items
     *
     * @param GetParameters  $getParameters
     * @param ApiCredentials $credentials
     *
     * @return Collection|null
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public static function findAll(GetParameters $getParameters = null, ApiCredentials $credentials = null)
    {
        /** @var AbstractModel $model */
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->getApi()->addGetParametersToEndpoint(static::$endpointResource, $getParameters);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }
}
