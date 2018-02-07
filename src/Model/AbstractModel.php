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

use BadFunctionCallException;
use JsonSerializable;
use Richardhj\Newsletter2Go\Api\Api;
use Richardhj\Newsletter2Go\Api\Tool\ApiCredentials;
use Psr\Http\Message\ResponseInterface;


/**
 * Class AbstractModel
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
abstract class AbstractModel implements JsonSerializable
{

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [];

    /**
     * Resource path on endpoint
     *
     * @var string
     */
    protected static $endpointResource;

    /**
     * The data representing the model
     *
     * @var array
     */
    private $data = [];

    /**
     * The api instance responsible for api communication
     *
     * @var Api
     */
    private $api;

    /**
     * Create a model instance from static context
     *
     * @return static
     */
    public static function createInstance()
    {
        return new static();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set api credentials
     *
     * @param ApiCredentials $credentials
     */
    public function setApiCredentials(ApiCredentials $credentials = null)
    {
        if (null === $credentials) {
            return;
        }

        $this->api = new Api($credentials);
    }

    /**
     * Set a property in data array
     *
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public function __set($key, $value)
    {
        if (!$value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Get a property from data array
     *
     * @param $key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        throw new \InvalidArgumentException(sprintf('Property "%s" is not represented in model data', $key));
    }

    /**
     * Enable magic function call
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws BadFunctionCallException
     */
    public function __call($name, $arguments)
    {
        // Convert a `$this->getIsBlacklisted()` to `$this->is_blacklisted`
        if (0 === strncmp($name, 'set', 3)) {
            return $this->{strtolower(ltrim(substr(preg_replace('/[A-Z]/', '_$0', $name), 3), '_'))}
                = reset($arguments);
        }
        if (0 === strncmp($name, 'get', 3)) {
            return $this->{strtolower(ltrim(substr(preg_replace('/[A-Z]/', '_$0', $name), 3), '_'))};
        }

        throw new BadFunctionCallException(sprintf('Unknown method "%s"', $name));
    }

    /**
     * Save the current model
     *
     * @return self
     */
    abstract public function save();

    /**
     * Get all configurable fields
     *
     * @return array
     */
    public static function getConfigurableFields()
    {
        return static::$configurableFields;
    }

    /**
     * Create a collection of models using data of an api call
     *
     * @param ResponseInterface $response
     *
     * @return Collection|null
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function createCollectionFromResponse(ResponseInterface $response)
    {
        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if (0 === $json->info->count || empty($json->value)) {
            return null;
        }

        /** @var AbstractModel[] $models */
        $models = [];

        foreach ((array)$json->value as $i => $data) {
            $models[$i] = clone $this;
            $models[$i]->setData((array)$data);
        }

        return new Collection($models);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array_filter(
            $this->data,
            function ($k) {
                return \in_array($k, static::getConfigurableFields(), true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
