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

use Richardhj\Newsletter2Go\Api\Api;


/**
 * Class ModelBasicSaveTrait
 *
 * @package Richardhj\Newsletter2Go\Api\Model
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
        $api      = $this->getApi();
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
