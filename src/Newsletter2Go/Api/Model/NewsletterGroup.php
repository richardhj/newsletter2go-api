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
 * Class NewsletterGroup
 *
 * @method NewsletterGroup setId($id)
 * @method NewsletterGroup setName($name)
 * @method NewsletterGroup setDescription($description)
 * @method NewsletterGroup setListId($listId)
 * @method string getId()
 * @method string getName()
 * @method string getDescription()
 * @method string getListId()
 *
 * @package Newsletter2Go\Api\Model
 */
class NewsletterGroup extends AbstractModel implements ModelDeletableInterface
{

    /**
     * {@inheritdoc}
     */
    protected static $configurableFields = [
        'name',
        'description',
        'list_id',
    ];


    /**
     * Find recipients by a selected list
     *
     * @param string         $lid The list id
     * @param GetParameters  $getParams
     * @param ApiCredentials $credentials
     *
     * @return Collection|null
     */
    public static function findByList($lid, GetParameters $getParams = null, ApiCredentials $credentials = null)
    {
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->api->fillEndpointWithParams('/lists/%s/groups', $lid);
        $endpoint = $model->api->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->api
            ->getHttpClient()
            ->get($endpoint);

        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if (0 === $json->info->count) {
            return null;
        }

        /** @var NewsletterGroup[] $models */
        $models = [];

        foreach ($json->value as $i => $data) {
            $models[$i] = clone $model;
            $models[$i]->setRow((array)$data);
        }

        return new Collection($models);
    }


    /**
     * Delete the current model
     *
     * @return bool
     */
    public function delete()
    {
        $endpoint = $this->api->fillEndpointWithParams('/groups/%s', $this->getId());

        $this->api
            ->getHttpClient()
            ->delete($endpoint);

        return true;
    }


    /**
     * {@inheritdoc}
     */
    function save()
    {
        // Update
        if (array_key_exists('id', $this->data)) {
            $endpoint = $this->getApi()->fillEndpointWithParams('/groups/%s', $this->getId());

            $this->getApi()
                ->getHttpClient()
                ->patch(
                    $endpoint,
                    [
                        'json' => $this,
                    ]
                );
        } // Create
        else {
            if (!array_key_exists('list_id', $this->data)) {
                throw new \LogicException('Provide a list id when creating a new group');
            }

            $response = $this->getApi()
                ->getHttpClient()
                ->post(
                    '/groups',
                    [
                        'json' => $this,
                    ]
                );

            $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

            $this->setId($json->value->id);
        }

        return $this;
    }
}
