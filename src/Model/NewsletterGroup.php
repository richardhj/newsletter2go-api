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
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class NewsletterGroup extends AbstractModel implements ModelDeletableInterface
{

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
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

        $endpoint = $model->getApi()->fillEndpointWithParams('/lists/%s/groups', $lid);
        $endpoint = $model->getApi()->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }

    /**
     * Delete the current model
     *
     * @return void
     */
    public function delete()
    {
        $endpoint = $this->getApi()->fillEndpointWithParams('/groups/%s', $this->getId());

        $this->getApi()
            ->getHttpClient()
            ->delete($endpoint);
    }

    // TODO: Implement https://docs.newsletter2go.com/#!/Group/removeRecipientsFromGroup (same as in NewsletterRecipient)
    // TODO: Implement https://docs.newsletter2go.com/#!/Group/getRecipientsByGroup (same as in NewsletterRecipient)
    // TODO: Implement https://docs.newsletter2go.com/#!/Group/addRecipientsToGroup (same as in NewsletterRecipient)
    // TODO: Implement https://docs.newsletter2go.com/#!/Group/removeRecipientFromGroup (same as in NewsletterRecipient)
    // TODO: Implement https://docs.newsletter2go.com/#!/Group/addRecipientToGroup (same as in NewsletterRecipient)

    /**
     * Save the current model
     *
     * @return self
     */
    public function save()
    {
        if (array_key_exists('id', $this->getData())) {
            // Update
            $endpoint = $this->getApi()->fillEndpointWithParams('/groups/%s', $this->getId());

            $this->getApi()
                ->getHttpClient()
                ->patch(
                    $endpoint,
                    [
                        'json' => $this,
                    ]
                );
        } else {
            // Create
            if (!array_key_exists('list_id', $this->getData())) {
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

            $this->setId($json->value[0]->id);
        }

        return $this;
    }
}
