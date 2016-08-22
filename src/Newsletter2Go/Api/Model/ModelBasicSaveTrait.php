<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Model;


use Newsletter2Go\Api\Api;


/**
 * Class ModelBasicSaveTrait
 * @package Newsletter2Go\Api\Model
 */
trait ModelBasicSaveTrait
{

    /**
     * Save the current item
     *
     * @return self
     */
    public function save()
    {
        /** @var Api $api */
        $api = $this->getApi();
        $endpoint = $api->fillEndpointWithParams(static::$endpointResource.'/%s', $this->getId());

        $api
            ->getHttpClient()
            ->patch(
                $endpoint,
                [
                    'json' => $this,
                ]
            );

        return $this;
    }
}
