<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Model;


use Newsletter2Go\Api\Tool\ApiCredentials;
use Newsletter2Go\Api\Tool\GetParameters;


/**
 * Class ModelBasicFindTrait
 *
 * @package Newsletter2Go\Api\Model
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
     */
    public static function findById($id, ApiCredentials $credentials = null)
    {
        /** @var AbstractModel $model */
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->getApi()->fillEndpointWithParams(static::$endpointResource . '/%s', $id);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);


        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if (0 === $json->info->count) {
            return null;
        }

        return $model->setRow((array) reset($json->value));
    }


    /**
     * Find all items
     *
     * @param GetParameters  $getParameters
     * @param ApiCredentials $credentials
     *
     * @return Collection|null
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
