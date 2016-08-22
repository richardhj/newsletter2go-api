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
use Newsletter2Go\Api\Tool\ApiCredentials;


/**
 * Class AbstractModel
 * @package Newsletter2Go\Api\Model
 */
abstract class AbstractModel implements \JsonSerializable
{

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [];


    /**
     * The data used for json
     *
     * @var array
     */
    protected $data = [];


    /**
     * The api instance responsible for api communication
     *
     * @var Api
     */
    protected $api;


    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }


    /**
     * AbstractModel constructor.
     * Create an api instance. Set api credentials if they are defined as constants
     */
    public function __construct()
    {
        $this->api = new Api();
//
//        if (defined(NEWSLETTER2GO_API_AUTHKEY)
//            && defined(NEWSLETTER2GO_API_USERNAME)
//            && defined(NEWSLETTER2GO_API_PASSWORD)
//        ) {
//            $this->setApiCredentials(
//                ApiCredentialsFactory::create(
//                    NEWSLETTER2GO_API_AUTHKEY,
//                    NEWSLETTER2GO_API_USERNAME,
//                    NEWSLETTER2GO_API_PASSWORD
//                )
//            );
//        }
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

        $this->getApi()->setApiCredentials($credentials);
    }


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
     * Set a property in data array
     *
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public function __set($key, $value)
    {
        if (strlen($value)) {
            $this->data[$key] = $value;
        }

        return $this;
    }


    /**
     * Get a property from data array
     *
     * @param $key
     *
     * @return mixed
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
     * @throws \BadFunctionCallException
     */
    public function __call($name, $arguments)
    {
        if (0 === strncmp($name, 'set', 3)) {
            return $this->{strtolower(ltrim(substr(preg_replace('/[A-Z]/', '_$0', $name), 3), '_'))} = reset(
                $arguments
            );
        } elseif (0 === strncmp($name, 'get', 3)) {
            return $this->{strtolower(ltrim(substr(preg_replace('/[A-Z]/', '_$0', $name), 3), '_'))};
        }

        throw new \BadFunctionCallException(sprintf('Unknown method "%s"', $name));
    }


    /**
     * Fetch the data
     *
     * @return array
     */
    public function row()
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
    public function setRow(array $data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * Save the current model
     *
     * @return self
     */
    abstract function save();


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
     *{@inheritdoc}
     */
    function jsonSerialize()
    {
        return array_filter(
            $this->data,
            function ($k) {
                return in_array($k, static::getConfigurableFields());
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
