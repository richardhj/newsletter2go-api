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
 * Class NewsletterRecipient
 *
 * @method NewsletterRecipient setId($id)
 * @method NewsletterRecipient setListId($listId)
 * @method NewsletterRecipient setEmail($email)
 * @method NewsletterRecipient setPhone($phone)
 * @method NewsletterRecipient setGender($gender)
 * @method NewsletterRecipient setFirstName($firstName)
 * @method NewsletterRecipient setLastName($lastName)
 * @method NewsletterRecipient setBirthday($birthday) Set the date of birth, in ISO 8601 format preferably
 * @method NewsletterRecipient setIsUnsubscribed($isUnsubscribed)
 * @method NewsletterRecipient setIsBlacklisted($isBlacklisted)
 * @method string getId()
 * @method string getListId()
 * @method string getEmail()
 * @method string getPhone()
 * @method string getGender()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getBirthday()
 * @method string getIsUnsubscribed()
 * @method string getIsBlacklisted()
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class NewsletterRecipient extends AbstractModel implements ModelDeletableInterface
{

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [
        'list_id',
        'email',
        'phone',
        'gender',
        'first_name',
        'last_name',
        'birthday',
        'is_unsubscribed',
        'is_blacklisted',
    ];

    /**
     * Find recipients by a selected list and group
     *
     * @param string         $lid The list id
     * @param string         $gid The group id
     * @param GetParameters  $getParams
     * @param ApiCredentials $credentials
     *
     * @return Collection|null
     */
    public static function findByListAndGroup(
        $lid,
        $gid,
        GetParameters $getParams = null,
        ApiCredentials $credentials = null
    ) {
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->getApi()->fillEndpointWithParams('/lists/%s/groups/%s/recipients', [$lid, $gid]);
        $endpoint = $model->getApi()->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }

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

        $endpoint = $model->getApi()->fillEndpointWithParams('/lists/%s/recipients', $lid);
        $endpoint = $model->getApi()->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }

    /**
     * Add this recipient to a particular group
     *
     * @param string $gid The group id
     */
    public function addToGroup($gid)
    {
        $endpoint = $this->getApi()->fillEndpointWithParams(
            '/lists/%s/groups/%s/recipients/%s',
            [
                $this->getListId(),
                $gid,
                $this->getId()
            ]
        );

        $this->getApi()
            ->getHttpClient()
            ->post($endpoint);
    }

    /**
     * Remove this recipient from a particular group
     *
     * @param string $gid The group id
     */
    public function removeFromGroup($gid)
    {
        $endpoint = $this->getApi()->fillEndpointWithParams(
            '/lists/%s/groups/%s/recipients/%s',
            [
                $this->getListId(),
                $gid,
                $this->getId()
            ]
        );

        $this->getApi()
            ->getHttpClient()
            ->delete($endpoint);
    }

    /**
     * Save the current model
     *
     * @return self
     */
    public function save()
    {
        if (array_key_exists('id', $this->getData())) {
            return $this->update();
        }

        $response = $this->getApi()->getHttpClient()
            ->post(
                '/recipients',
                [
                    'json' => $this,
                ]
            );

        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());
        $this->setId($json->value[0]->id);

        return $this;
    }

    /**
     * Delete the current model
     *
     * @return void
     */
    public function delete()
    {
        $endpoint = $this->getApi()->fillEndpointWithParams(
            '/lists/%s/recipients/%s',
            [
                $this->getListId(),
                $this->getId()
            ]
        );

        $this->getApi()
            ->getHttpClient()
            ->delete($endpoint);
    }

    // TODO: Implement
    //          https://docs.newsletter2go.com/#!/Recipient/removeRecipientsFromGroup,
    //          https://docs.newsletter2go.com/#!/Recipient/removeRecipientsFromList,
    //          https://docs.newsletter2go.com/#!/Recipient/updateRecipients,
    //          https://docs.newsletter2go.com/#!/Recipient/addRecipientsToGroup
    //          (all using a fiql filter)

    // TODO: Implement
    //          https://docs.newsletter2go.com/#!/Recipient/importRecipientsInit,
    //          https://docs.newsletter2go.com/#!/Recipient/importRecipientsSave,
    //          https://docs.newsletter2go.com/#!/Recipient/importRecipientsStatistics

    // TODO: Implement
    //          https://docs.newsletter2go.com/#!/Recipient/subscribeRecipient


    /**
     * Update the current recipient by a given id
     *
     * @return self
     */
    private function update()
    {
        $endpoint = $this->getApi()->fillEndpointWithParams(
            '/lists/%s/recipients/%s',
            [
                $this->getListId(),
                $this->getId()
            ]
        );

        $this->getApi()
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
